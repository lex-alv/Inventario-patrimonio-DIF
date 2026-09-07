@extends('layouts.app')

@section('content')
    <!-- Encabezado de Página -->
    <div class="row g-3 mb-4 align-items-center">
        <div class="col-md-8">
            <h4 class="mb-1 fw-bold text-dark d-flex align-items-center">
                <i class="bi bi-pie-chart-fill me-2" style="color: var(--gov-primary);"></i>Panel de Control Patrimonial
            </h4>
            <div class="small text-muted">
                Sistema Municipal DIF San Antonio la Isla · <span class="fw-semibold text-secondary">Ejercicio Fiscal Vigente</span>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('bienes.reporteGeneralPdf') }}" class="btn btn-outline-danger btn-sm me-1">
                <i class="bi bi-file-earmark-pdf me-1"></i>Inventario PDF
            </a>
            <a href="{{ route('bienes.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Nuevo Activo
            </a>
        </div>
    </div>

    <!-- Widgets KPI de Alto Nivel -->
    <div class="row g-3 mb-4">
        <!-- Tarjeta: Total Activos -->
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card kpi-primary">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="kpi-label">Padrón de Activos</span>
                        <h3 class="kpi-value text-dark">{{ number_format($totalBienes) }}</h3>
                        <div class="small text-muted mt-1">Bienes muebles en censo</div>
                    </div>
                    <div class="kpi-icon-wrap">
                        <i class="bi bi-boxes"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Valor en Libros -->
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card kpi-success">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="kpi-label">Valor en Libros</span>
                        <h3 class="kpi-value" style="color: var(--gov-status-success-text);">${{ number_format($valorTotalInventario, 2) }}</h3>
                        <div class="small text-muted mt-1">Costo histórico acumulado</div>
                    </div>
                    <div class="kpi-icon-wrap">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta: En Resguardo -->
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card kpi-info">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="kpi-label">En Resguardo</span>
                        <h3 class="kpi-value" style="color: var(--gov-accent-teal);">{{ number_format($bienesEnResguardo) }}</h3>
                        <div class="small text-muted mt-1">{{ number_format($bienesEnAlmacen) }} activos en bodega</div>
                    </div>
                    <div class="kpi-icon-wrap">
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Bajas Patrimoniales -->
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card kpi-danger">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="kpi-label">Desincorporados</span>
                        <h3 class="kpi-value" style="color: var(--gov-status-danger-text);">{{ number_format($totalBajas) }}</h3>
                        <div class="small text-muted mt-1">Con acta y dictamen formal</div>
                    </div>
                    <div class="kpi-icon-wrap">
                        <i class="bi bi-file-earmark-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Principal: Tabla CONAC y Paneles Laterales -->
    <div class="row g-4">
        <!-- Tabla Resumen por Cuenta Armonizada (CONAC) -->
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-journal-text me-2" style="color: var(--gov-primary);"></i>Concentrado por Cuenta Contable (CONAC)
                    </h6>
                    <span class="badge badge-gov-secondary">Armonización Contable</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3" style="width: 100px;">Cuenta</th>
                                    <th>Concepto / Clasificación</th>
                                    <th class="text-center" style="width: 90px;">Bienes</th>
                                    <th class="text-end pe-3" style="width: 140px;">Valor Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cuentasResumen as $cuenta)
                                    <tr>
                                        <td class="ps-3">
                                            <span class="badge badge-gov-secondary font-mono-num">{{ $cuenta->codigo }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-dark">{{ $cuenta->nombre }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-gov-primary">{{ $cuenta->bienes_count }}</span>
                                        </td>
                                        <td class="text-end pe-3 font-mono-num fw-semibold text-dark">
                                            ${{ number_format($cuenta->bienes_sum_costo_adquisicion, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox me-1"></i>No hay saldos registrados en el ejercicio.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Lateral: Dependencias y Últimas Cédulas -->
        <div class="col-lg-5">
            <!-- Bienes por Dependencia -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-geo-alt me-2" style="color: var(--gov-accent-teal);"></i>Bienes Activos por Dependencia
                    </h6>
                </div>
                <div class="card-body p-3">
                    @forelse($areasResumen as $area)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                            <span class="small fw-medium text-dark">{{ $area->nombre }}</span>
                            <span class="badge badge-gov-info font-mono-num">{{ $area->bienes_count }} activos</span>
                        </div>
                    @empty
                        <div class="text-muted small text-center py-2">Sin áreas registradas.</div>
                    @endforelse
                </div>
            </div>

            <!-- Últimas Cédulas Expedidas -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-clock-history me-2" style="color: var(--gov-secondary);"></i>Últimas Cédulas Expedidas
                    </h6>
                    <a href="{{ route('resguardos.index') }}" class="btn btn-outline-secondary btn-sm" style="font-size: 0.7rem;">Ver todas</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        @forelse($ultimosResguardos as $res)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
                                <div>
                                    <div class="fw-semibold text-dark">
                                        <span class="font-mono-num text-primary">{{ $res->folio_resguardo }}</span> · {{ $res->empleado->nombre_completo }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        {{ $res->detalles->count() }} activos asignados · {{ \Carbon\Carbon::parse($res->fecha_emision)->format('d/m/Y') }}
                                    </div>
                                </div>
                                <span class="badge badge-gov-success">{{ $res->estatus }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-3">
                                <i class="bi bi-inbox me-1"></i>Sin resguardos recientes expedidos.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection