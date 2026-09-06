@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-pencil-square me-2"></i>Expedición de Cédula de Resguardo
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('resguardos.store') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Folio del Resguardo*</label>
                                <input type="text" name="folio_resguardo"
                                    class="form-control @error('folio_resguardo') is-invalid @enderror"
                                    placeholder="Ej. RES-2026-0001" value="{{ old('folio_resguardo') }}" required>
                                @error('folio_resguardo')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-5">
                                <label class="form-label fw-bold small">Servidor Público Receptor*</label>
                                <select name="empleado_id" class="form-select @error('empleado_id') is-invalid @enderror"
                                    required>
                                    <option value="">Seleccione funcionario...</option>
                                    @foreach($empleados as $emp)
                                        <option value="{{ $emp->id }}" {{ old('empleado_id') == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->nombre_completo }} — {{ $emp->cargo }}
                                            ({{ $emp->unidadAdministrativa->clave ?? 'Área' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('empleado_id')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Fecha de Emisión*</label>
                                <input type="date" name="fecha_emision" class="form-control"
                                    value="{{ old('fecha_emision', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <h6 class="fw-bold text-secondary border-bottom pb-2 mb-3">
                            Selecciona los activos a asignar en esta cédula:
                        </h6>

                        @error('bienes')
                            <div class="alert alert-danger py-2 small">{{ $message }}</div>
                        @enderror

                        <div class="table-responsive border rounded mb-4" style="max-height: 280px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th width="40" class="text-center ps-3">Sel.</th>
                                        <th>No. Inventario</th>
                                        <th>Descripción</th>
                                        <th>Marca / Modelo</th>
                                        <th>Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bienesDisponibles as $bien)
                                        <tr>
                                            <td class="text-center ps-3">
                                                <input class="form-check-input" type="checkbox" name="bienes[]"
                                                    value="{{ $bien->id }}">
                                            </td>
                                            <td class="fw-bold">{{ $bien->numero_inventario }}</td>
                                            <td>{{ $bien->descripcion }}</td>
                                            <td>{{ $bien->marca ?? 'S/M' }} - {{ $bien->modelo ?? 'S/M' }}</td>
                                            <td>${{ number_format($bien->costo_adquisicion, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3 text-muted">
                                                No hay bienes disponibles sin resguardo previo. Registra activos primero.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('resguardos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4">Generar y Guardar Resguardo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection