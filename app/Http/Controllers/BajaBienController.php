<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\BajaBien;
use App\Models\DetalleResguardo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BajaBienController extends Controller
{
    public function index()
    {
        $bajas = BajaBien::with('bien.cuentaContable', 'bien.unidadAdministrativa')
            ->latest()
            ->paginate(10);

        return view('bajas.index', compact('bajas'));
    }

    public function create(Request $request)
    {
        // Solo bienes que no estén dados de baja
        $bienes = Bien::where('estatus', '!=', 'Baja')
            ->orderBy('numero_inventario')
            ->get();

        $bienSeleccionado = $request->has('bien_id')
            ? Bien::find($request->bien_id)
            : null;

        return view('bajas.create', compact('bienes', 'bienSeleccionado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bien_id' => 'required|exists:bienes,id',
            'tipo_baja' => 'required|in:Desuso / Inservible,Robo / Siniestro,Donación,Dación en Pago,Venta',
            'folio_acta' => 'required|string|max:100',
            'fecha_baja' => 'required|date',
            'dictamen_tecnico' => 'required|string',
            'documento_soporte' => 'nullable|file|mimes:pdf,jpg,png|max:4096',
        ]);

        DB::transaction(function () use ($request) {
            $bien = Bien::findOrFail($request->bien_id);

            // Guardar documento si se adjuntó
            $rutaDocumento = null;
            if ($request->hasFile('documento_soporte')) {
                $rutaDocumento = $request->file('documento_soporte')->store('bajas_documentos', 'public');
            }

            // 1. Crear el registro en bajas_bienes
            BajaBien::create([
                'bien_id' => $bien->id,
                'tipo_baja' => $request->tipo_baja,
                'folio_acta' => $request->folio_acta,
                'fecha_baja' => $request->fecha_baja,
                'dictamen_tecnico' => $request->dictamen_tecnico,
                'documento_soporte_url' => $rutaDocumento,
            ]);

            // 2. Cambiar estatus del bien
            $bien->update(['estatus' => 'Baja']);

            // 3. Si estaba en algún resguardo activo, registrar fecha de devolución
            DetalleResguardo::where('bien_id', $bien->id)
                ->whereNull('fecha_devolucion')
                ->update([
                    'fecha_devolucion' => now(),
                    'observaciones_devolucion' => 'Baja patrimonial mediante acta: ' . $request->folio_acta,
                ]);
        });

        return redirect()->route('bajas.index')
            ->with('success', 'Bien desincorporado y dado de baja patrimonial correctamente.');
    }
}