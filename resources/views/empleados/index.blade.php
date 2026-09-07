@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center g-2">
                <div class="col-md-6">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-people-fill me-2" style="color: var(--gov-primary);"></i>Directorio de Servidores Públicos
                    </h5>
                    <span class="small text-muted">Padrón de funcionarios, áreas de adscripción y control de resguardos</span>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('empleados.index') }}" method="GET"
                        class="d-flex gap-2 justify-content-md-end">
                        <div class="input-group input-group-sm" style="max-width: 320px;">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" name="buscar" class="form-control border-start-0"
                                placeholder="Buscar por nombre o no. empleado..." value="{{ $buscar }}">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                        @if($buscar)
                            <a href="{{ route('empleados.index') }}" class="btn btn-outline-secondary btn-sm"
                                title="Limpiar filtro de búsqueda">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width: 130px;">No. Empleado</th>
                            <th>Servidor Público</th>
                            <th>Cargo / Puesto</th>
                            <th>Área de Adscripción</th>
                            <th class="text-center" style="width: 140px;">Cédulas Vigentes</th>
                            <th class="text-end pe-3" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($empleados as $emp)
                            <tr>
                                <td class="ps-3">
                                    <span class="font-mono-num fw-bold text-dark">{{ $emp->numero_empleado }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $emp->nombre_completo }}</div>
                                    <small class="text-muted font-mono-num" style="font-size: 0.75rem;">
                                        {{ $emp->correo_institucional ?? 'Sin correo asignado' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $emp->cargo }}</span>
                                </td>
                                <td>
                                    <span class="text-secondary">{{ $emp->unidadAdministrativa->nombre }}</span>
                                </td>
                                <td class="text-center">
                                    @if($emp->resguardos_vigentes_count > 0)
                                        <span class="badge badge-gov-primary font-mono-num">{{ $emp->resguardos_vigentes_count }} activa(s)</span>
                                    @else
                                        <span class="badge badge-gov-secondary">Sin resguardos</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('empleados.show', $emp->id) }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-folder2-open me-1"></i>Expediente
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox me-1 fs-5 d-block mb-1"></i>
                                    No se encontraron servidores públicos con los criterios especificados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($empleados->hasPages())
            <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="small text-muted">Mostrando {{ $empleados->firstItem() }} a {{ $empleados->lastItem() }} de {{ $empleados->total() }} servidores públicos</span>
                <div>{{ $empleados->links() }}</div>
            </div>
        @endif
    </div>
@endsection