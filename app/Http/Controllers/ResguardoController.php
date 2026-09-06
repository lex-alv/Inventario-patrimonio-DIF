<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Empleado;
use App\Models\Resguardo;
use App\Models\DetalleResguardo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ResguardoController extends Controller
{
    public function index()
    {
        $resguardos = Resguardo::with(['empleado.unidadAdministrativa', 'detalles.bien'])
            ->latest()
            ->paginate(10);

        return view('resguardos.index', compact('resguardos'));
    }

    public function create()
    {
        $empleados = Empleado::where('estatus', 'Activo')
            ->with('unidadAdministrativa')
            ->orderBy('nombre')
            ->get();

        // Solo bienes activos que NO tengan un resguardo vigente (donde fecha_devolucion sea NULL)
        $bienesDisponibles = Bien::where('estatus', 'Activo')
            ->whereDoesntHave('detallesResguardos', function ($query) {
                $query->whereNull('fecha_devolucion');
            })
            ->orderBy('numero_inventario')
            ->get();

        return view('resguardos.create', compact('empleados', 'bienesDisponibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'folio_resguardo' => 'required|string|max:50|unique:resguardos,folio_resguardo',
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_emision' => 'required|date',
            'bienes' => 'required|array|min:1',
            'bienes.*' => 'exists:bienes,id',
        ]);

        DB::transaction(function () use ($request) {
            $resguardo = Resguardo::create([
                'folio_resguardo' => $request->folio_resguardo,
                'empleado_id' => $request->empleado_id,
                'fecha_emision' => $request->fecha_emision,
                'estatus' => 'Vigente',
            ]);

            foreach ($request->bienes as $bienId) {
                DetalleResguardo::create([
                    'resguardo_id' => $resguardo->id,
                    'bien_id' => $bienId,
                    'fecha_asignacion' => now(),
                    'observaciones_entrega' => 'Asignación formal de equipo mediante cédula.',
                ]);
            }
        });

        return redirect()->route('resguardos.index')
            ->with('success', 'Cédula de Resguardo generada exitosamente.');
    }

    public function show(Resguardo $resguardo)
    {
        $resguardo->load(['empleado.unidadAdministrativa', 'detalles.bien.cuentaContable']);
        return view('resguardos.show', compact('resguardo'));
    }

    public function descargarPdf(Resguardo $resguardo)
    {
        $resguardo->load(['empleado.unidadAdministrativa', 'detalles.bien.cuentaContable']);

        $pdf = Pdf::loadView('resguardos.pdf', compact('resguardo'))
            ->setPaper('letter', 'portrait');

        return $pdf->download("Resguardo_{$resguardo->folio_resguardo}.pdf");
    }
}