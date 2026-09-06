@extends('layouts.app')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary">
                <i class="bi bi-file-earmark-lock2 me-2"></i>Cédulas de Resguardo Individual
            </h5>
            <a href="{{ route('resguardos.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Nueva Cédula de Resguardo
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Folio</th>
                            <th>Servidor Público Responsable</th>
                            <th>Área</th>
                            <th>Fecha de Emisión</th>
                            <th>Bienes Asignados</th>
                            <th>Estatus</th>
                            <th class="text-end pe-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resguardos as $resguardo)
                            <tr>
                                <td class="ps-3 fw-bold">{{ $resguardo->folio_resguardo }}</td>
                                <td>
                                    <div>{{ $resguardo->empleado->nombre_completo }}</div>
                                    <small class="text-muted">{{ $resguardo->empleado->cargo }}</small>
                                </td>
                                <td>{{ $resguardo->empleado->unidadAdministrativa->nombre }}</td>
                                <td>{{ \Carbon\Carbon::parse($resguardo->fecha_emision)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $resguardo->detalles->count() }} bienes</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $resguardo->estatus }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('resguardos.show', $resguardo->id) }}"
                                        class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-eye"></i> Ver Cédula
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No se han expedido cédulas de resguardo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($resguardos->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $resguardos->links() }}
            </div>
        @endif
    </div>
@endsection