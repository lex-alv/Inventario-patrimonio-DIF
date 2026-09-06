@extends('layouts.app')

@section('content')
    <div class="row g-4">
        <!-- Ficha del Funcionario -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 70px; height: 70px;">
                        <i class="bi bi-person-badge fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $empleado->nombre_completo }}</h5>
                    <span class="badge bg-light text-dark border mb-3">{{ $empleado->cargo }}</span>

                    <div class="text-start border-top pt-3 small">
                        <p class="mb-2"><strong>No. Empleado:</strong> {{ $empleado->numero_empleado }}</p>
                        <p class="mb-2"><strong>Área:</strong> {{ $empleado->unidadAdministrativa->nombre }}</p>
                        <p class="mb-2"><strong>Correo:</strong> {{ $empleado->correo_institucional ?? 'No asignado' }}</p>
                        <p class="mb-0"><strong>Estatus Laboral:</strong> <span
                                class="badge bg-success">{{ $empleado->estatus }}</span></p>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <a href="{{ route('empleados.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver al Directorio
                    </a>
                </div>
            </div>
        </div>

        <!-- Padrón de Activos en Custodia -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-box-seam me-2 text-primary"></i>Activos Actualmente Bajo su Custodia
                    </h6>
                    <span class="badge bg-primary">{{ $bienesActivos->count() }} bienes a cargo</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 small">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">No. Inventario</th>
                                    <th>Descripción</th>
                                    <th>Marca / Serie</th>
                                    <th>Folio Cédula</th>
                                    <th class="text-end pe-3">Valor Reg.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bienesActivos as $item)
                                    <tr>
                                        <td class="ps-3 fw-bold">
                                            <a href="{{ route('bienes.show', $item['bien']->id) }}"
                                                class="text-decoration-none">
                                                {{ $item['bien']->numero_inventario }}
                                            </a>
                                        </td>
                                        <td>{{ $item['bien']->descripcion }}</td>
                                        <td>{{ $item['bien']->marca ?? 'S/M' }} / {{ $item['bien']->numero_serie ?? 'S/N' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $item['resguardo_folio'] }}</span>
                                        </td>
                                        <td class="text-end pe-3">${{ number_format($item['bien']->costo_adquisicion, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            El servidor público no tiene bienes muebles bajo resguardo activo actualmente.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Historial de Cédulas Expedidas -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Historial de Cédulas Individuales
                    </h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        @forelse($empleado->resguardos as $resguardo)
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ $resguardo->folio_resguardo }}</h6>
                                    <span class="text-muted">Emitido el
                                        {{ \Carbon\Carbon::parse($resguardo->fecha_emision)->format('d/m/Y') }} ·
                                        {{ $resguardo->detalles->count() }} bienes vinculados</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('resguardos.show', $resguardo->id) }}"
                                        class="btn btn-outline-secondary btn-sm">Ver</a>
                                    <a href="{{ route('resguardos.pdf', $resguardo->id) }}"
                                        class="btn btn-outline-danger btn-sm">PDF</a>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted text-center py-3">Sin cédulas registradas en el historial.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection