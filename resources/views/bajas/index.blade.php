@extends('layouts.app')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary">
                <i class="bi bi-archive me-2"></i>Historial de Bajas y Desincorporaciones Patrimoniales
            </h5>
            <a href="{{ route('bajas.create') }}" class="btn btn-danger btn-sm">
                <i class="bi bi-dash-circle me-1"></i>Tramitar Baja de Activo
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">No. Inventario</th>
                            <th>Descripción</th>
                            <th>Área</th>
                            <th>Tipo de Baja</th>
                            <th>Acta / Dictamen</th>
                            <th>Fecha</th>
                            <th>Dictamen Técnico</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bajas as $baja)
                            <tr>
                                <td class="ps-3 fw-bold text-danger">
                                    {{ $baja->bien->numero_inventario ?? 'S/N' }}
                                </td>
                                <td>
                                    <div>{{ $baja->bien->descripcion ?? 'Sin descripción' }}</div>
                                    <small class="text-muted">Serie: {{ $baja->bien->numero_serie ?? 'S/N' }}</small>
                                </td>
                                <td>
                                    {{ $baja->bien->unidadAdministrativa->nombre ?? 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $baja->tipo_baja }}</span>
                                </td>
                                <td><strong>{{ $baja->folio_acta }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($baja->fecha_baja)->format('d/m/Y') }}</td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($baja->dictamen_tecnico, 45) }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    No se han registrado bajas o desincorporaciones patrimoniales.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($bajas->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $bajas->links() }}
            </div>
        @endif
    </div>
@endsection