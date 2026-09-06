@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-file-earmark-text me-2"></i>Ficha del Activo: {{ $bien->numero_inventario }}
                    </h5>
                    <a href="{{ route('bienes.index') }}" class="btn btn-outline-secondary btn-sm">Volver al Inventario</a>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-8">
                            <h4 class="fw-bold text-primary">{{ $bien->descripcion }}</h4>
                            <p class="text-muted mb-1"><strong>Área:</strong> {{ $bien->unidadAdministrativa->nombre }}</p>
                            <p class="text-muted mb-1"><strong>Cuenta Armonizada:</strong>
                                {{ $bien->cuentaContable->codigo }} - {{ $bien->cuentaContable->nombre }}</p>
                            <p class="text-muted mb-0"><strong>Estatus:</strong> 
                                @if($bien->estatus == 'Activo')
                                    <span class="badge bg-success">{{ $bien->estatus }}</span>
                                @elseif($bien->estatus == 'Baja')
                                    <span class="badge bg-danger">{{ $bien->estatus }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ $bien->estatus }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="p-2 border rounded bg-white d-inline-block shadow-sm">
                                {!! $qrCode !!}
                            </div>
                            <small class="d-block text-muted mt-2">Código QR Institucional</small>
                        </div>
                    </div>

                    <table class="table table-bordered small mb-4">
                        <tbody>
                            <tr>
                                <th class="bg-light w-25">Marca</th>
                                <td>{{ $bien->marca ?? 'N/A' }}</td>
                                <th class="bg-light w-25">Modelo</th>
                                <td>{{ $bien->modelo ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">No. Serie</th>
                                <td>{{ $bien->numero_serie ?? 'S/N' }}</td>
                                <th class="bg-light">No. Factura</th>
                                <td>{{ $bien->factura_numero ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Fecha de Compra</th>
                                <td>{{ $bien->fecha_adquisicion ? \Carbon\Carbon::parse($bien->fecha_adquisicion)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <th class="bg-light">Costo Histórico</th>
                                <td>${{ number_format($bien->costo_adquisicion, 2) }} MXN</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Conservación</th>
                                <td>{{ $bien->estado_conservacion }}</td>
                                <th class="bg-light">Tipo de Entrada</th>
                                <td>{{ $bien->tipo_adquisicion }}</td>
                            </tr>
                        </tbody>
                    </table>

                    @php
                        $resguardoActivo = $bien->detallesResguardos->firstWhere('fecha_devolucion', null);
                    @endphp

                    @if($resguardoActivo)
                        <div class="alert alert-info py-2 px-3 small d-flex justify-content-between align-items-center mb-0">
                            <div>
                                <i class="bi bi-person-check-fill me-1"></i>
                                <strong>Actualmente en Resguardo:</strong> {{ $resguardoActivo->resguardo->empleado->nombre_completo }} ({{ $resguardoActivo->resguardo->folio_resguardo }})
                            </div>
                            <a href="{{ route('resguardos.show', $resguardoActivo->resguardo->id) }}" class="btn btn-sm btn-outline-primary">Ver Cédula</a>
                        </div>
                    @elseif($bien->estatus == 'Activo')
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('bajas.create', ['bien_id' => $bien->id]) }}" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-dash-circle me-1"></i>Tramitar Baja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection