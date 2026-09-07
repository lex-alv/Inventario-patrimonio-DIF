@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h5 class="mb-0 fw-bold d-flex align-items-center">
                    <i class="bi bi-file-earmark-lock2 me-2" style="color: var(--gov-primary);"></i>Cédulas de Resguardo Individual
                </h5>
                <span class="small text-muted">Control de asignación patrimonial y responsabilidad por servidor público</span>
            </div>
            <a href="{{ route('resguardos.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Nueva Cédula de Resguardo
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width: 140px;">Folio Cédula</th>
                            <th>Servidor Público Responsable</th>
                            <th>Área de Adscripción</th>
                            <th style="width: 130px;">Fecha de Emisión</th>
                            <th class="text-center" style="width: 130px;">Bienes en Custodia</th>
                            <th class="text-center" style="width: 90px;">Estatus</th>
                            <th class="text-end pe-3" style="width: 110px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resguardos as $resguardo)
                            <tr>
                                <td class="ps-3">
                                    <span class="font-mono-num fw-bold text-dark">{{ $resguardo->folio_resguardo }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $resguardo->empleado->nombre_completo }}</div>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $resguardo->empleado->cargo }}</small>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $resguardo->empleado->unidadAdministrativa->nombre }}</span>
                                </td>
                                <td>
                                    <span class="font-mono-num text-dark">{{ \Carbon\Carbon::parse($resguardo->fecha_emision)->format('d/m/Y') }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-gov-primary font-mono-num">{{ $resguardo->detalles->count() }} bienes</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-gov-success">{{ $resguardo->estatus }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('resguardos.show', $resguardo->id) }}"
                                            class="btn btn-outline-secondary" title="Ver detalle de la cédula">
                                            <i class="bi bi-eye me-1"></i>Ver
                                        </a>
                                        <a href="{{ route('resguardos.pdf', $resguardo->id) }}"
                                            class="btn btn-outline-danger" title="Descargar PDF oficial">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox me-1 fs-5 d-block mb-1"></i>
                                    No se han expedido cédulas de resguardo patrimonial en el sistema.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($resguardos->hasPages())
            <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
                <span class="small text-muted">Mostrando {{ $resguardos->firstItem() }} a {{ $resguardos->lastItem() }} de {{ $resguardos->total() }} registros</span>
                <div>{{ $resguardos->links() }}</div>
            </div>
        @endif
    </div>
@endsection