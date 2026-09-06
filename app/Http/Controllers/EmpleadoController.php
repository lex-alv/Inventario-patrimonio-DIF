<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Directorio de servidores públicos y estado de resguardos.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $empleados = Empleado::with('unidadAdministrativa')
            ->withCount([
                'resguardos as resguardos_vigentes_count' => function ($query) {
                    $query->where('estatus', 'Vigente');
                }
            ])
            ->when($buscar, function ($query, $buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('primer_apellido', 'like', "%{$buscar}%")
                    ->orWhere('segundo_apellido', 'like', "%{$buscar}%")
                    ->orWhere('numero_empleado', 'like', "%{$buscar}%");
            })
            ->orderBy('primer_apellido')
            ->paginate(12);

        return view('empleados.index', compact('empleados', 'buscar'));
    }

    /**
     * Expediente individual de resguardos (Entrega-Recepción).
     */
    public function show(Empleado $empleado)
    {
        $empleado->load([
            'unidadAdministrativa',
            'resguardos.detalles' => function ($query) {
                $query->with('bien.cuentaContable');
            }
        ]);

        // Separar bienes actualmente en custodia (fecha_devolucion IS NULL)
        $bienesActivos = collect();
        foreach ($empleado->resguardos as $resguardo) {
            foreach ($resguardo->detalles as $detalle) {
                if (is_null($detalle->fecha_devolucion) && $detalle->bien->estatus === 'Activo') {
                    $bienesActivos->push([
                        'resguardo_folio' => $resguardo->folio_resguardo,
                        'resguardo_fecha' => $resguardo->fecha_emision,
                        'bien' => $detalle->bien,
                        'detalle_id' => $detalle->id,
                    ]);
                }
            }
        }

        return view('empleados.show', compact('empleado', 'bienesActivos'));
    }
}