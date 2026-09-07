<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Empleado;
use App\Models\Resguardo;
use App\Models\BajaBien;
use App\Models\CuentaContable;
use App\Models\UnidadAdministrativa;

class DashboardController extends Controller
{
    public function index()
    {
        // Métricas numéricas principales
        $totalBienes = Bien::count();
        $valorTotalInventario = Bien::where('estatus', '!=', 'Baja')->sum('costo_adquisicion');

        $bienesEnResguardo = Bien::where('estatus', 'Activo')
            ->whereHas('detallesResguardos', function ($query) {
                $query->whereNull('fecha_devolucion');
            })->count();

        $bienesEnAlmacen = Bien::where('estatus', 'Activo')
            ->whereDoesntHave('detallesResguardos', function ($query) {
                $query->whereNull('fecha_devolucion');
            })->count();

        $totalBajas = BajaBien::count();
        $totalEmpleados = Empleado::where('estatus', 'Activo')->count();

        // Distribución del patrimonio por Cuenta Contable Armonizada (CONAC)
        $filtroBienesVigentes = function ($query) {
            $query->where('estatus', '!=', 'Baja');
        };

        $cuentasResumen = CuentaContable::withCount(['bienes' => $filtroBienesVigentes])
            ->withSum(['bienes' => $filtroBienesVigentes], 'costo_adquisicion')
            ->having('bienes_count', '>', 0)
            ->get();

        // Distribución por Área Operativa del DIF
        $areasResumen = UnidadAdministrativa::withCount(['bienes' => $filtroBienesVigentes])->get();

        // Últimos 5 movimientos de resguardo expedidos
        $ultimosResguardos = Resguardo::with(['empleado', 'detalles'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBienes',
            'valorTotalInventario',
            'bienesEnResguardo',
            'bienesEnAlmacen',
            'totalBajas',
            'totalEmpleados',
            'cuentasResumen',
            'areasResumen',
            'ultimosResguardos'
        ));
    }
}