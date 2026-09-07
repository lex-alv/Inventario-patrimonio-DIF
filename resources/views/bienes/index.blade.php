@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h5 class="mb-0 fw-bold d-flex align-items-center">
                    <i class="bi bi-box-seam me-2" style="color: var(--gov-primary);"></i>Inventario General de Bienes Muebles
                </h5>
                <span class="small text-muted">Padrón de activos fijos del SMDIF</span>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('bienes.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Registrar Nuevo Bien
                </a>
                <a href="{{ route('bienes.importar') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-file-earmark-arrow-up me-1"></i>Importar CSV
                </a>
                <a href="{{ route('bienes.imprimirEtiquetas') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-printer me-1"></i>Etiquetas QR
                </a>
                <a href="{{ route('bienes.reporteGeneralPdf') }}" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-file-earmark-pdf me-1"></i>Reporte PDF
                </a>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width: 140px;">No. Inventario</th>
                            <th>Descripción del Bien</th>
                            <th style="width: 160px;">Cuenta CONAC</th>
                            <th>Área de Adscripción</th>
                            <th class="text-center" style="width: 100px;">Conservación</th>
                            <th class="text-center" style="width: 90px;">Estatus</th>
                            <th class="text-end pe-3" style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bienes as $bien)
                            <tr>
                                <td class="ps-3">
                                    <span class="font-mono-num fw-bold text-dark">{{ $bien->numero_inventario }}</span>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark">{{ Str::limit($bien->descripcion, 50) }}</div>
                                    <div class="small text-muted font-mono-num" style="font-size: 0.75rem;">
                                        Serie: {{ $bien->numero_serie ?? 'S/N' }} @if($bien->marca) · Marca: {{ $bien->marca }} @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-gov-secondary font-mono-num">{{ $bien->cuentaContable->codigo }}</span>
                                    <small class="d-block text-muted text-truncate" style="max-width: 150px; font-size: 0.75rem;">{{ $bien->cuentaContable->nombre }}</small>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $bien->unidadAdministrativa->nombre }}</span>
                                </td>
                                <td class="text-center">
                                    @if($bien->estado_conservacion == 'Bueno')
                                        <span class="badge badge-gov-success">Bueno</span>
                                    @elseif($bien->estado_conservacion == 'Regular')
                                        <span class="badge badge-gov-warning">Regular</span>
                                    @else
                                        <span class="badge badge-gov-danger">Malo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($bien->estatus == 'Activo')
                                        <span class="badge badge-gov-success">{{ $bien->estatus }}</span>
                                    @elseif($bien->estatus == 'Baja')
                                        <span class="badge badge-gov-danger">{{ $bien->estatus }}</span>
                                    @else
                                        <span class="badge badge-gov-warning">{{ $bien->estatus }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('bienes.show', $bien->id) }}" class="btn btn-outline-secondary" title="Ver ficha y código QR">
                                            <i class="bi bi-qr-code-scan"></i>
                                        </a>
                                        @if($bien->estatus != 'Baja' && Auth::check() && Auth::user()->rol === 'admin')
                                            <a href="{{ route('bajas.create', ['bien_id' => $bien->id]) }}" class="btn btn-outline-danger" title="Tramitar Baja">
                                                <i class="bi bi-dash-circle"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox me-1 fs-5 d-block mb-1"></i>
                                    No se encontraron registros de bienes patrimoniales en el catálogo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($bienes->hasPages())
            <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="small text-muted">Mostrando {{ $bienes->firstItem() }} a {{ $bienes->lastItem() }} de {{ $bienes->total() }} bienes</span>
                <div>{{ $bienes->links() }}</div>
            </div>
        @endif
    </div>
@endsection