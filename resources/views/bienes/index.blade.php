@extends('layouts.app')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary">
                <i class="bi bi-card-list me-2"></i>Inventario de Bienes Muebles
            </h5>
            <a href="{{ route('bienes.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Registrar Nuevo Bien
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('bienes.reporteGeneralPdf') }}" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-file-earmark-pdf me-1"></i>Descargar Inventario General (PDF)
                </a>
                <a href="{{ route('bienes.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Registrar Nuevo Bien
                </a>
                <a href="{{ route('bienes.imprimirEtiquetas') }}" target="_blank" class="btn btn-outline-dark btn-sm">
                    <i class="bi bi-printer me-1"></i>Imprimir Etiquetas QR
                </a>
                <a href="{{ route('bienes.importar') }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-file-earmark-arrow-up me-1"></i>Importar CSV
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">No. Inventario</th>
                            <th>Descripción</th>
                            <th>Cuenta Contable</th>
                            <th>Área / Ubicación</th>
                            <th>Estado</th>
                            <th>Estatus</th>
                            <th class="text-end pe-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bienes as $bien)
                            <tr>
                                <td class="ps-3 fw-bold text-dark">{{ $bien->numero_inventario }}</td>
                                <td>
                                    <div>{{ Str::limit($bien->descripcion, 45) }}</div>
                                    <small class="text-muted">Serie: {{ $bien->numero_serie ?? 'S/N' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $bien->cuentaContable->codigo }}</span>
                                    <small
                                        class="d-block text-muted">{{ Str::limit($bien->cuentaContable->nombre, 25) }}</small>
                                </td>
                                <td>{{ $bien->unidadAdministrativa->nombre }}</td>
                                <td>
                                    @if($bien->estado_conservacion == 'Bueno')
                                        <span class="badge bg-success">Bueno</span>
                                    @elseif($bien->estado_conservacion == 'Regular')
                                        <span class="badge bg-warning text-dark">Regular</span>
                                    @else
                                        <span class="badge bg-danger">Malo</span>
                                    @endif
                                </td>
                                <td>
                                    @if($bien->estatus == 'Activo')
                                        <span class="badge bg-success">{{ $bien->estatus }}</span>
                                    @elseif($bien->estatus == 'Baja')
                                        <span class="badge bg-danger">{{ $bien->estatus }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ $bien->estatus }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('bienes.show', $bien->id) }}" class="btn btn-outline-secondary btn-sm"
                                        title="Ver ficha y QR">
                                        <i class="bi bi-qr-code-scan"></i>
                                    </a>
                                    @if($bien->estatus != 'Baja')
                                        <a href="{{ route('bajas.create', ['bien_id' => $bien->id]) }}"
                                            class="btn btn-outline-danger btn-sm" title="Tramitar Baja">
                                            <i class="bi bi-dash-circle"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    No se encontraron registros de bienes patrimoniales.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($bienes->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $bienes->links() }}
            </div>
        @endif
    </div>
@endsection