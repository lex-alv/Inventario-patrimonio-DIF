@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold d-flex align-items-center" style="color: var(--gov-status-danger-text);">
                            <i class="bi bi-file-earmark-minus me-2"></i>Acta de Desincorporación Patrimonial
                        </h5>
                        <span class="small text-muted">Trámite de baja de activo y descargo del inventario institucional</span>
                    </div>
                    <a href="{{ route('bajas.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body p-4">

                    <div class="alert alert-warning small mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-6"></i>
                        <div>
                            <strong>Aviso de Contraloría:</strong> La desincorporación patrimonial inhabilita el bien para resguardos futuros y requiere dictamen técnico y folio de acta de sesión formal.
                        </div>
                    </div>

                    <form action="{{ route('bajas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Activo a Desincorporar*</label>
                                <select name="bien_id" class="form-select @error('bien_id') is-invalid @enderror" required>
                                    <option value="">Seleccione el bien patrimonial...</option>
                                    @foreach($bienes as $bien)
                                        <option value="{{ $bien->id }}" {{ (old('bien_id') == $bien->id || ($bienSeleccionado && $bienSeleccionado->id == $bien->id)) ? 'selected' : '' }}>
                                            {{ $bien->numero_inventario }} — {{ $bien->descripcion }}
                                            ({{ $bien->marca ?? 'S/M' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('bien_id')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Causa / Motivo de la Baja*</label>
                                <select name="tipo_baja" class="form-select @error('tipo_baja') is-invalid @enderror"
                                    required>
                                    <option value="Desuso / Inservible" {{ old('tipo_baja') == 'Desuso / Inservible' ? 'selected' : '' }}>Desuso / Inservible</option>
                                    <option value="Robo / Siniestro" {{ old('tipo_baja') == 'Robo / Siniestro' ? 'selected' : '' }}>Robo / Siniestro</option>
                                    <option value="Donación" {{ old('tipo_baja') == 'Donación' ? 'selected' : '' }}>Donación</option>
                                    <option value="Dación en Pago" {{ old('tipo_baja') == 'Dación en Pago' ? 'selected' : '' }}>Dación en Pago</option>
                                    <option value="Venta" {{ old('tipo_baja') == 'Venta' ? 'selected' : '' }}>Venta</option>
                                </select>
                                @error('tipo_baja')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Folio Acta de Sesión / Dictamen*</label>
                                <input type="text" name="folio_acta"
                                    class="form-control font-mono-num @error('folio_acta') is-invalid @enderror"
                                    placeholder="Ej. ACTA-ORD-2026-04" value="{{ old('folio_acta') }}" required>
                                @error('folio_acta')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha Formal de la Baja*</label>
                                <input type="date" name="fecha_baja" class="form-control"
                                    value="{{ old('fecha_baja', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Expediente Soporte Digital (PDF / Imagen)</label>
                                <input type="file" name="documento_soporte"
                                    class="form-control @error('documento_soporte') is-invalid @enderror">
                                @error('documento_soporte')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Dictamen Técnico y Justificación Administrativa*</label>
                                <textarea name="dictamen_tecnico" rows="3"
                                    class="form-control @error('dictamen_tecnico') is-invalid @enderror"
                                    placeholder="Indicar el dictamen técnico o los motivos por los cuales el activo no resulta costeable, reparable o útil para el servicio público..."
                                    required>{{ old('dictamen_tecnico') }}</textarea>
                                @error('dictamen_tecnico')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('bajas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bi bi-file-earmark-x me-1"></i>Procesar Baja Patrimonial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection