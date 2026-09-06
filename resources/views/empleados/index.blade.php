@extends('layouts.app')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-people-fill me-2 text-primary"></i>Directorio de Servidores Públicos
                    </h5>
                    <small class="text-muted">Control de resguardos individuales y entrega-recepción de área</small>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('empleados.index') }}" method="GET"
                        class="d-flex gap-2 justify-content-md-end mt-2 mt-md-0">
                        <input type="text" name="buscar" class="form-control form-control-sm"
                            placeholder="Buscar por nombre o No. empleado..." value="{{ $buscar }}">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        @if($buscar)
                            <a href="{{ route('empleados.index') }}" class="btn btn-outline-secondary btn-sm"
                                title="Limpiar filtro">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">No. Empleado</th>
                            <th>Nombre del Servidor Público</th>
                            <th>Cargo</th>
                            <th>Área de Adscripción</th>
                            <th class="text-center">Cédulas Vigentes</th>
                            <th class="text-end pe-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($empleados as $emp)
                            <tr>
                                <td class="ps-3 fw-bold text-dark">{{ $emp->numero_empleado }}</td>
                                <td>
                                    <div class="fw-bold">{{ $emp->nombre_completo }}</div>
                                    <small
                                        class="text-muted">{{ $emp->correo_institucional ?? 'Sin correo registrado' }}</small>
                                </td>
                                <td>{{ $emp->cargo }}</td>
                                <td>{{ $emp->unidadAdministrativa->nombre }}</td>
                                <td class="text-center">
                                    @if($emp->resguardos_vigentes_count > 0)
                                        <span class="badge bg-primary">{{ $emp->resguardos_vigentes_count }} activa(s)</span>
                                    @else
                                        <span class="badge bg-light text-muted border">Sin resguardos</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('empleados.show', $emp->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-folder2-open me-1"></i>Expediente
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No se encontraron empleados con los
                                    criterios de búsqueda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($empleados->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $empleados->links() }}
            </div>
        @endif
    </div>
@endsection