@extends('layouts.app')

@section('content')
    <div class="row g-4">
        <!-- Ficha del Funcionario -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 68px; height: 68px; background-color: var(--gov-primary-subtle); color: var(--gov-primary); border-radius: var(--gov-radius); border: 1px solid rgba(15, 45, 89, 0.15);">
                        <i class="bi bi-person-badge fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark">{{ $empleado->nombre_completo }}</h5>
                    <span class="badge badge-gov-secondary mb-3">{{ $empleado->cargo }}</span>

                    <div class="text-start border-top pt-3 small">
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">No. Empleado:</span>
                            <span class="font-mono-num fw-bold text-dark">{{ $empleado->numero_empleado }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted d-block">Área de Adscripción:</span>
                            <span class="fw-medium text-dark">{{ $empleado->unidadAdministrativa->nombre }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted d-block">Correo Institucional:</span>
                            <span class="font-mono-num text-dark">{{ $empleado->correo_institucional ?? 'No asignado' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-1">
                            <span class="text-muted">Estatus Laboral:</span>
                            <span class="badge badge-gov-success">{{ $empleado->estatus }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <a href="{{ route('empleados.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="bi bi-arrow-left me-1"></i>Volver al Directorio
                    </a>
                </div>
            </div>
        </div>

        <!-- Padrón de Activos en Custodia -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="bi bi-box-seam me-2" style="color: var(--gov-primary);"></i>Activos Actualmente Bajo su Custodia
                        </h6>
                        <span class="small text-muted">Bienes muebles con resguardo individual vigente</span>
                    </div>
                    <span class="badge badge-gov-primary font-mono-num">{{ $bienesActivos->count() }} bienes a cargo</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3" style="width: 130px;">No. Inventario</th>
                                    <th>Descripción del Bien</th>
                                    <th>Marca / Serie</th>
                                    <th style="width: 140px;">Folio Cédula</th>
                                    <th class="text-end pe-3" style="width: 120px;">Valor Reg.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bienesActivos as $item)
                                    <tr>
                                        <td class="ps-3">
                                            <a href="{{ route('bienes.show', $item['bien']->id) }}"
                                                class="font-mono-num fw-bold text-decoration-none">
                                                {{ $item['bien']->numero_inventario }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-dark">{{ $item['bien']->descripcion }}</div>
                                        </td>
                                        <td>
                                            <small class="text-muted font-mono-num" style="font-size: 0.75rem;">
                                                {{ $item['bien']->marca ?? 'S/M' }} / {{ $item['bien']->numero_serie ?? 'S/N' }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge badge-gov-secondary font-mono-num">{{ $item['resguardo_folio'] }}</span>
                                        </td>
                                        <td class="text-end pe-3 font-mono-num text-dark fw-semibold">
                                            ${{ number_format($item['bien']->costo_adquisicion, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox me-1"></i>El servidor público no tiene bienes muebles bajo custodia activa actualmente.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Historial de Cédulas Expedidas -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-clock-history me-2" style="color: var(--gov-secondary);"></i>Historial de Cédulas Individuales Expedidas
                    </h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        @forelse($empleado->resguardos as $resguardo)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-3">
                                <div>
                                    <h6 class="mb-1 fw-bold">
                                        <span class="font-mono-num text-primary">{{ $resguardo->folio_resguardo }}</span>
                                    </h6>
                                    <span class="text-muted">Emitido el
                                        {{ \Carbon\Carbon::parse($resguardo->fecha_emision)->format('d/m/Y') }} ·
                                        <span class="font-mono-num">{{ $resguardo->detalles->count() }}</span> bienes vinculados</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('resguardos.show', $resguardo->id) }}"
                                        class="btn btn-outline-secondary btn-sm">Ver</a>
                                    <a href="{{ route('resguardos.pdf', $resguardo->id) }}"
                                        class="btn btn-outline-danger btn-sm">PDF</a>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-3">
                                <i class="bi bi-inbox me-1"></i>Sin cédulas registradas en el historial.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection