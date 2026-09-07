@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="bi bi-file-earmark-text me-2" style="color: var(--gov-primary);"></i>Ficha Técnica del Activo
                        </h5>
                        <span class="small text-muted font-mono-num">Registro: {{ $bien->numero_inventario }}</span>
                    </div>
                    <a href="{{ route('bienes.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver al Inventario
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center mb-4 pb-3 border-bottom">
                        <div class="col-md-8">
                            <span class="badge badge-gov-primary font-mono-num mb-2">{{ $bien->numero_inventario }}</span>
                            <h4 class="fw-bold text-dark mb-2">{{ $bien->descripcion }}</h4>
                            <div class="small text-muted mb-1">
                                <strong class="text-dark">Área:</strong> {{ $bien->unidadAdministrativa->nombre }}
                            </div>
                            <div class="small text-muted mb-2">
                                <strong class="text-dark">Cuenta CONAC:</strong> 
                                <span class="font-mono-num">{{ $bien->cuentaContable->codigo }}</span> — {{ $bien->cuentaContable->nombre }}
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="small fw-semibold text-dark">Estatus:</span>
                                @if($bien->estatus == 'Activo')
                                    <span class="badge badge-gov-success">{{ $bien->estatus }}</span>
                                @elseif($bien->estatus == 'Baja')
                                    <span class="badge badge-gov-danger">{{ $bien->estatus }}</span>
                                @else
                                    <span class="badge badge-gov-warning">{{ $bien->estatus }}</span>
                                @endif
                                
                                <span class="small fw-semibold text-dark ms-2">Estado:</span>
                                @if($bien->estado_conservacion == 'Bueno')
                                    <span class="badge badge-gov-success">{{ $bien->estado_conservacion }}</span>
                                @elseif($bien->estado_conservacion == 'Regular')
                                    <span class="badge badge-gov-warning">{{ $bien->estado_conservacion }}</span>
                                @else
                                    <span class="badge badge-gov-danger">{{ $bien->estado_conservacion }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-center mt-3 mt-md-0">
                            <div class="p-2 border rounded bg-white d-inline-block shadow-sm">
                                {!! $qrCode !!}
                            </div>
                            <div class="small text-muted mt-2 font-mono-num" style="font-size: 0.75rem;">
                                Código QR Oficial de Identificación
                            </div>
                        </div>
                    </div>

                    <!-- Especificaciones Técnicas y Contables -->
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="bi bi-info-circle me-1" style="color: var(--gov-primary);"></i>Detalles Técnicos y de Registro Contable
                    </h6>
                    <table class="table table-bordered small mb-4">
                        <tbody>
                            <tr>
                                <th class="bg-light w-25 text-secondary">Marca</th>
                                <td class="w-25 text-dark fw-medium">{{ $bien->marca ?? 'N/A' }}</td>
                                <th class="bg-light w-25 text-secondary">Modelo</th>
                                <td class="w-25 text-dark fw-medium">{{ $bien->modelo ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-secondary">No. Serie</th>
                                <td class="font-mono-num text-dark">{{ $bien->numero_serie ?? 'S/N' }}</td>
                                <th class="bg-light text-secondary">No. Factura / Soporte</th>
                                <td class="font-mono-num text-dark">{{ $bien->factura_numero ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-secondary">Fecha de Adquisición</th>
                                <td class="text-dark">{{ $bien->fecha_adquisicion ? \Carbon\Carbon::parse($bien->fecha_adquisicion)->format('d/m/Y') : 'N/A' }}</td>
                                <th class="bg-light text-secondary">Costo Histórico</th>
                                <td class="font-mono-num fw-bold text-dark">${{ number_format($bien->costo_adquisicion, 2) }} MXN</td>
                            </tr>
                            <tr>
                                <th class="bg-light text-secondary">Conservación</th>
                                <td class="text-dark">{{ $bien->estado_conservacion }}</td>
                                <th class="bg-light text-secondary">Tipo de Incorporación</th>
                                <td class="text-dark">{{ $bien->tipo_adquisicion }}</td>
                            </tr>
                            @if($bien->observaciones)
                            <tr>
                                <th class="bg-light text-secondary">Observaciones</th>
                                <td colspan="3" class="text-muted">{{ $bien->observaciones }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    @php
                        $resguardoActivo = $bien->detallesResguardos->firstWhere('fecha_devolucion', null);
                    @endphp

                    @if($resguardoActivo)
                        <div class="alert alert-info py-2 px-3 small d-flex justify-content-between align-items-center mb-0">
                            <div>
                                <i class="bi bi-person-check-fill me-2 fs-6"></i>
                                <strong>Actualmente en Custodia:</strong> {{ $resguardoActivo->resguardo->empleado->nombre_completo }} 
                                <span class="badge badge-gov-primary font-mono-num ms-1">{{ $resguardoActivo->resguardo->folio_resguardo }}</span>
                            </div>
                            <a href="{{ route('resguardos.show', $resguardoActivo->resguardo->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>Ver Cédula
                            </a>
                        </div>
                    @elseif($bien->estatus == 'Activo' && Auth::check() && Auth::user()->rol === 'admin')
                        <div class="d-flex justify-content-end gap-2 pt-2">
                            <a href="{{ route('bajas.create', ['bien_id' => $bien->id]) }}" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-dash-circle me-1"></i>Tramitar Baja Patrimonial
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection