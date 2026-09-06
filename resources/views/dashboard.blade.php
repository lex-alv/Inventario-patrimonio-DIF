@extends('layouts.app')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-secondary mb-0">
                <i class="bi bi-pie-chart-fill me-2 text-primary"></i>Panel de Control Patrimonial
            </h4>
            <small class="text-muted">Sistema Municipal DIF San Antonio la Isla · Ejercicio Fiscal Vigente</small>
        </div>

        <!-- Tarjeta: Total Activos -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-primary border-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Total Activos</span>
                        <h3 class="fw-bold mb-0 text-primary">{{ $totalBienes }}</h3>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                        <i class="bi bi-boxes fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Valor en Libros -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-success border-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Valor en Libros</span>
                        <h3 class="fw-bold mb-0 text-success">${{ number_format($valorTotalInventario, 2) }}</h3>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-circle">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta: En Resguardo -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-info border-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">En Resguardo</span>
                        <h3 class="fw-bold mb-0 text-info">{{ $bienesEnResguardo }}</h3>
                        <small class="text-muted">{{ $bienesEnAlmacen }} en bodega</small>
                    </div>
                    <div class="bg-info-subtle text-info p-3 rounded-circle">
                        <i class="bi bi-person-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Bajas Patrimoniales -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-danger border-4 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Desincorporados</span>
                        <h3 class="fw-bold mb-0 text-danger">{{ $totalBajas }}</h3>
                        <small class="text-muted">Con dictamen formal</small>
                    </div>
                    <div class="bg-danger-subtle text-danger p-3 rounded-circle">
                        <i class="bi bi-file-earmark-x fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Tabla Resumen por Cuenta Armonizada (CONAC) -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-journal-text me-2"></i>Concentrado por Cuenta Contable (CONAC)
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Cuenta</th>
                                    <th>Concepto</th>
                                    <th class="text-center">Bienes</th>
                                    <th class="text-end pe-3">Valor Acumulado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cuentasResumen as $cuenta)
                                    <tr>
                                        <td class="ps-3 fw-bold text-dark">{{ $cuenta->codigo }}</td>
                                        <td><small>{{ $cuenta->nombre }}</small></td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $cuenta->bienes_count }}</span>
                                        </td>
                                        <td class="text-end pe-3 fw-bold">
                                            ${{ number_format($cuenta->bienes_sum_costo_adquisicion, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No hay saldos registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Lateral: Distribución por Área y Últimos Resguardos -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-geo-alt me-2"></i>Bienes Activos por Dependencia
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($areasResumen as $area)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small">{{ $area->nombre }}</span>
                            <span class="badge bg-light text-dark border">{{ $area->bienes_count }} activos</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-clock-history me-2"></i>Últimas Cédulas Expedidas
                    </h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        @forelse($ultimosResguardos as $res)
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <div>
                                    <strong>{{ $res->folio_resguardo }}</strong> · {{ $res->empleado->nombre_completo }}
                                    <div class="text-muted">{{ $res->detalles->count() }} activos asignados</div>
                                </div>
                                <span class="badge bg-success">{{ $res->estatus }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-3">Sin resguardos recientes.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection