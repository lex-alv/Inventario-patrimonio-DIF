<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\CuentaContable;
use App\Models\UnidadAdministrativa;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BienController extends Controller
{
    /**
     * Muestra el inventario general de bienes.
     */
    public function index()
    {
        $bienes = Bien::with([
            'cuentaContable',
            'unidadAdministrativa',
            'detallesResguardos' => function ($query) {
                $query->whereNull('fecha_devolucion')->with('resguardo.empleado');
            }
        ])
            ->latest()
            ->paginate(15);

        return view('bienes.index', compact('bienes'));
    }

    /**
     * Formulario para registrar un nuevo bien patrimonial.
     */
    public function create()
    {
        $cuentas = CuentaContable::orderBy('codigo')->get();
        $unidades = UnidadAdministrativa::orderBy('nombre')->get();

        return view('bienes.create', compact('cuentas', 'unidades'));
    }

    /**
     * Almacena el bien aplicando las reglas mínimas normativas.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_inventario' => 'required|string|max:50|unique:bienes,numero_inventario',
            'cuenta_contable_id' => 'required|exists:cuentas_contables,id',
            'unidad_administrativa_id' => 'required|exists:unidades_administrativas,id',
            'descripcion' => 'required|string',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'factura_numero' => 'nullable|string|max:100',
            'fecha_adquisicion' => 'nullable|date',
            'costo_adquisicion' => 'required|numeric|min:0',
            'tipo_adquisicion' => 'required|in:Compra,Donación,Transferencia,Inventario Inicial',
            'estado_conservacion' => 'required|in:Bueno,Regular,Malo',
            'observaciones' => 'nullable|string',
        ]);

        $validated['estatus'] = 'Activo';

        Bien::create($validated);

        return redirect()->route('bienes.index')
            ->with('success', 'Bien mueble registrado exitosamente en el inventario patrimonial.');
    }

    /**
     * Muestra la ficha técnica detallada del bien y su código QR.
     */
    public function show(Bien $biene)
    {
        // En Laravel resource el parámetro se llama $biene por la flexión en singular
        $bien = $biene->load(['cuentaContable', 'unidadAdministrativa', 'detallesResguardos.resguardo.empleado']);

        // Generación del código QR en formato SVG embebido
        $qrCode = QrCode::size(180)->generate($bien->numero_inventario);

        return view('bienes.show', compact('bien', 'qrCode'));
    }
    /**
     * Localiza el activo por su número de inventario escaneado y redirige a su ficha técnica.
     */
    public function buscarPorNumero(Request $request)
    {
        $numero = $request->input('numero');

        $bien = Bien::where('numero_inventario', $numero)->first();

        if ($bien) {
            return redirect()->route('bienes.show', $bien->id);
        }

        return redirect()->route('escaner')
            ->with('error', "No se encontró ningún activo registrado con el identificador: {$numero}");
    }
}