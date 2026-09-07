@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="bi bi-pencil-square me-2" style="color: var(--gov-primary);"></i>Expedición de Cédula de Resguardo
                        </h5>
                        <span class="small text-muted">Asignación formal de custodia patrimonial a servidor público</span>
                    </div>
                    <a href="{{ route('resguardos.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('resguardos.store') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Folio del Resguardo*</label>
                                <input type="text" name="folio_resguardo"
                                    class="form-control font-mono-num @error('folio_resguardo') is-invalid @enderror"
                                    placeholder="Ej. RES-2026-0001" value="{{ old('folio_resguardo') }}" required>
                                @error('folio_resguardo')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Servidor Público Receptor*</label>
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
                                <label class="form-label">Fecha de Emisión*</label>
                                <input type="date" name="fecha_emision" class="form-control"
                                    value="{{ old('fecha_emision', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3 d-flex align-items-center">
                            <i class="bi bi-check2-square me-2" style="color: var(--gov-accent-teal);"></i>Selecciona los activos a asignar en esta cédula:
                        </h6>

                        @error('bienes')
                            <div class="alert alert-danger py-2 small mb-3">{{ $message }}</div>
                        @enderror

                        <div class="table-responsive border rounded mb-4" style="max-height: 280px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th width="45" class="text-center ps-3">Sel.</th>
                                        <th style="width: 140px;">No. Inventario</th>
                                        <th>Descripción</th>
                                        <th>Marca / Modelo</th>
                                        <th class="text-end pe-3" style="width: 120px;">Costo Reg.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bienesDisponibles as $bien)
                                        <tr>
                                            <td class="text-center ps-3">
                                                <input class="form-check-input" type="checkbox" name="bienes[]"
                                                    value="{{ $bien->id }}">
                                            </td>
                                            <td>
                                                <span class="font-mono-num fw-bold text-dark">{{ $bien->numero_inventario }}</span>
                                            </td>
                                            <td class="text-dark">{{ $bien->descripcion }}</td>
                                            <td class="small text-muted">{{ $bien->marca ?? 'S/M' }} - {{ $bien->modelo ?? 'S/M' }}</td>
                                            <td class="text-end pe-3 font-mono-num text-dark">${{ number_format($bien->costo_adquisicion, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                <i class="bi bi-inbox me-1"></i>No hay bienes disponibles sin resguardo previo. Registra activos primero.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('resguardos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-1"></i>Generar y Guardar Resguardo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection