<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\CuentaContable;
use App\Models\UnidadAdministrativa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportacionBienController extends Controller
{
    public function create()
    {
        return view('bienes.importar');
    }

    public function store(Request $request)
    {
        $request->validate([
            'archivo_csv' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $archivo = $request->file('archivo_csv');
        $handle = fopen($archivo->getRealPath(), 'r');

        // Leer la primera fila (cabeceras)
        $cabeceras = fgetcsv($handle, 2000, ',');

        $insertados = 0;
        $errores = [];
        $filaNumero = 1;

        DB::beginTransaction();

        try {
            while (($fila = fgetcsv($handle, 2000, ',')) !== false) {
                $filaNumero++;

                // Ignorar filas totalmente vacías
                if (empty(array_filter($fila))) {
                    continue;
                }

                // Estructura esperada de columnas en el CSV:
                // [0] numero_inventario
                // [1] codigo_cuenta (ej. 1241)
                // [2] nombre_area (ej. URIS o Coordinación Administrativa)
                // [3] descripcion
                // [4] marca
                // [5] modelo
                // [6] numero_serie
                // [7] costo_adquisicion
                // [8] estado_conservacion (Bueno, Regular, Malo)

                $numInventario = trim($fila[0] ?? '');
                $codigoCuenta = trim($fila[1] ?? '');
                $nombreArea = trim($fila[2] ?? '');
                $descripcion = trim($fila[3] ?? '');

                if (empty($numInventario) || empty($descripcion)) {
                    $errores[] = "Fila {$filaNumero}: Falta el número de inventario o la descripción.";
                    continue;
                }

                // Buscar o asociar cuenta y área
                $cuenta = CuentaContable::where('codigo', $codigoCuenta)->first();
                $area = UnidadAdministrativa::where('nombre', 'like', "%{$nombreArea}%")->first();

                if (!$cuenta || !$area) {
                    $errores[] = "Fila {$filaNumero}: Cuenta contable '{$codigoCuenta}' o área '{$nombreArea}' no válida.";
                    continue;
                }

                Bien::updateOrCreate(
                    ['numero_inventario' => $numInventario],
                    [
                        'cuenta_contable_id' => $cuenta->id,
                        'unidad_administrativa_id' => $area->id,
                        'descripcion' => $descripcion,
                        'marca' => trim($fila[4] ?? 'S/M'),
                        'modelo' => trim($fila[5] ?? 'S/M'),
                        'numero_serie' => trim($fila[6] ?? 'S/N'),
                        'costo_adquisicion' => floatval($fila[7] ?? 0),
                        'estado_conservacion' => in_array(trim($fila[8] ?? ''), ['Bueno', 'Regular', 'Malo']) ? trim($fila[8]) : 'Bueno',
                        'tipo_adquisicion' => 'Compra',
                        'fecha_adquisicion' => now(),
                        'estatus' => 'Activo',
                        'codigo_qr' => $numInventario,
                    ]
                );

                $insertados++;
            }

            fclose($handle);
            DB::commit();

            $mensaje = "Censo importado: {$insertados} activos procesados exitosamente.";
            if (count($errores) > 0) {
                $mensaje .= " Advertencias: " . implode(' | ', array_slice($errores, 0, 3));
            }

            return redirect()->route('bienes.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Error en el archivo CSV: ' . $e->getMessage());
        }
    }
}