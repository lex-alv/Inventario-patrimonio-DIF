@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary">
                        Cédula de Resguardo Individual: {{ $resguardo->folio_resguardo }}
                    </h5>
                    <a href="{{ route('resguardos.pdf', $resguardo->id) }}" class="btn btn-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Descargar Cédula PDF
                    </a>
                    <a href="{{ route('resguardos.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light p-3 rounded mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Servidor Público:</strong>
                                    {{ $resguardo->empleado->nombre_completo }}
                                </p>
                                <p class="mb-1"><strong>Cargo:</strong> {{ $resguardo->empleado->cargo }}</p>
                                <p class="mb-0"><strong>No. Empleado:</strong> {{ $resguardo->empleado->numero_empleado }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Área de Adscripción:</strong>
                                    {{ $resguardo->empleado->unidadAdministrativa->nombre }}
                                </p>
                                <p class="mb-1"><strong>Fecha de Emisión:</strong>
                                    {{ \Carbon\Carbon::parse($resguardo->fecha_emision)->format('d/m/Y') }}
                                </p>
                                <p class="mb-0"><strong>Estatus:</strong> <span
                                        class="badge bg-success">{{ $resguardo->estatus }}</span></p>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3">Bienes Asignados</h6>
                    <table class="table table-bordered small">
                        <thead class="table-light">
                            <tr>
                                <th>No. Inventario</th>
                                <th>Descripción</th>
                                <th>Serie</th>
                                <th>Estado</th>
                                <th class="text-end">Valor Registrado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resguardo->detalles as $detalle)
                                <tr>
                                    <td class="fw-bold">{{ $detalle->bien->numero_inventario }}</td>
                                    <td>{{ $detalle->bien->descripcion }}</td>
                                    <td>{{ $detalle->bien->numero_serie ?? 'S/N' }}</td>
                                    <td>{{ $detalle->bien->estado_conservacion }}</td>
                                    <td class="text-end">${{ number_format($detalle->bien->costo_adquisicion, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection