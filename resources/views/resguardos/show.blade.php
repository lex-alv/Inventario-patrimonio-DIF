@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="bi bi-file-earmark-lock2 me-2" style="color: var(--gov-primary);"></i>Cédula de Resguardo Individual
                        </h5>
                        <span class="small text-muted font-mono-num">Folio: {{ $resguardo->folio_resguardo }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('resguardos.pdf', $resguardo->id) }}" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-file-earmark-pdf me-1"></i>Descargar Cédula PDF
                        </a>
                        <a href="{{ route('resguardos.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Ficha Resumen del Funcionario Responsable -->
                    <div class="bg-light p-3 rounded border mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Servidor Público Custodio</div>
                                <div class="fw-bold text-dark fs-6">{{ $resguardo->empleado->nombre_completo }}</div>
                                <div class="small text-secondary">{{ $resguardo->empleado->cargo }}</div>
                                <div class="small text-muted font-mono-num mt-1">No. Empleado: {{ $resguardo->empleado->numero_empleado }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Adscripción y Expedición</div>
                                <div class="fw-semibold text-dark">{{ $resguardo->empleado->unidadAdministrativa->nombre }}</div>
                                <div class="small text-muted mt-1">
                                    Fecha de Emisión: <span class="font-mono-num fw-medium text-dark">{{ \Carbon\Carbon::parse($resguardo->fecha_emision)->format('d/m/Y') }}</span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-gov-success">{{ $resguardo->estatus }}</span>
                                    <span class="badge badge-gov-secondary font-mono-num ms-1">{{ $resguardo->detalles->count() }} bienes vinculados</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Bienes en Custodia -->
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                        <i class="bi bi-boxes me-2" style="color: var(--gov-primary);"></i>Relación de Bienes Muebles en Custodia
                    </h6>
                    <div class="table-responsive border rounded">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3" style="width: 140px;">No. Inventario</th>
                                    <th>Descripción del Activo</th>
                                    <th style="width: 140px;">No. Serie</th>
                                    <th class="text-center" style="width: 110px;">Conservación</th>
                                    <th class="text-end pe-3" style="width: 130px;">Valor Registrado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($resguardo->detalles as $detalle)
                                    <tr>
                                        <td class="ps-3">
                                            <a href="{{ route('bienes.show', $detalle->bien->id) }}" class="font-mono-num fw-bold text-decoration-none">
                                                {{ $detalle->bien->numero_inventario }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-dark">{{ $detalle->bien->descripcion }}</div>
                                            @if($detalle->bien->marca)
                                                <small class="text-muted" style="font-size: 0.75rem;">Marca: {{ $detalle->bien->marca }} · Mod: {{ $detalle->bien->modelo ?? 'S/M' }}</small>
                                            @endif
                                        </td>
                                        <td class="font-mono-num text-dark">{{ $detalle->bien->numero_serie ?? 'S/N' }}</td>
                                        <td class="text-center">
                                            @if($detalle->bien->estado_conservacion == 'Bueno')
                                                <span class="badge badge-gov-success">Bueno</span>
                                            @elseif($detalle->bien->estado_conservacion == 'Regular')
                                                <span class="badge badge-gov-warning">Regular</span>
                                            @else
                                                <span class="badge badge-gov-danger">Malo</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-3 font-mono-num fw-semibold text-dark">
                                            ${{ number_format($detalle->bien->costo_adquisicion, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox me-1"></i>No hay bienes asociados a esta cédula de resguardo.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold ps-3 py-2 text-secondary">Total Valuado en Custodia:</td>
                                    <td class="text-end pe-3 font-mono-num fw-bold text-dark py-2">
                                        ${{ number_format($resguardo->detalles->sum(fn($d) => $d->bien->costo_adquisicion), 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection