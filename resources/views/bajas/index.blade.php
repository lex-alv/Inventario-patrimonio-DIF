@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h5 class="mb-0 fw-bold d-flex align-items-center">
                    <i class="bi bi-file-earmark-x me-2" style="color: var(--gov-status-danger-text);"></i>Historial de Desincorporaciones y Bajas Patrimoniales
                </h5>
                <span class="small text-muted">Registro oficial y dictámenes técnicos avalados por Junta de Gobierno</span>
            </div>
            <a href="{{ route('bajas.create') }}" class="btn btn-danger btn-sm">
                <i class="bi bi-dash-circle me-1"></i>Tramitar Baja de Activo
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width: 140px;">No. Inventario</th>
                            <th>Descripción del Activo</th>
                            <th>Área de Origen</th>
                            <th style="width: 140px;">Causa de Baja</th>
                            <th style="width: 150px;">Acta / Dictamen</th>
                            <th style="width: 110px;">Fecha</th>
                            <th>Dictamen Técnico</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bajas as $baja)
                            <tr>
                                <td class="ps-3">
                                    <span class="font-mono-num fw-bold" style="color: var(--gov-status-danger-text);">
                                        {{ $baja->bien->numero_inventario ?? 'S/N' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark">{{ $baja->bien->descripcion ?? 'Sin descripción' }}</div>
                                    <small class="text-muted font-mono-num" style="font-size: 0.75rem;">Serie: {{ $baja->bien->numero_serie ?? 'S/N' }}</small>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $baja->bien->unidadAdministrativa->nombre ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-gov-danger">{{ $baja->tipo_baja }}</span>
                                </td>
                                <td>
                                    <span class="font-mono-num fw-semibold text-dark">{{ $baja->folio_acta }}</span>
                                </td>
                                <td>
                                    <span class="font-mono-num text-dark">{{ \Carbon\Carbon::parse($baja->fecha_baja)->format('d/m/Y') }}</span>
                                </td>
                                <td>
                                    <div class="text-muted small text-truncate" style="max-width: 260px;" title="{{ $baja->dictamen_tecnico }}">
                                        {{ $baja->dictamen_tecnico }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox me-1 fs-5 d-block mb-1"></i>
                                    No se han registrado bajas o desincorporaciones patrimoniales en el ejercicio.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($bajas->hasPages())
            <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="small text-muted">Mostrando {{ $bajas->firstItem() }} a {{ $bajas->lastItem() }} de {{ $bajas->total() }} actas</span>
                <div>{{ $bajas->links() }}</div>
            </div>
        @endif
    </div>
@endsection