@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="bi bi-file-earmark-minus me-2"></i>Acta de Desincorporación Patrimonial
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('bajas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold small">Activo a Desincorporar*</label>
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
                                <label class="form-label fw-bold small">Motivo de Baja*</label>
                                <select name="tipo_baja" class="form-select @error('tipo_baja') is-invalid @enderror"
                                    required>
                                    <option value="Desuso / Inservible">Desuso / Inservible</option>
                                    <option value="Robo / Siniestro">Robo / Siniestro</option>
                                    <option value="Donación">Donación</option>
                                    <option value="Dación en Pago">Dación en Pago</option>
                                    <option value="Venta">Venta</option>
                                </select>
                                @error('tipo_baja')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Folio Acta de Sesión / Dictamen*</label>
                                <input type="text" name="folio_acta"
                                    class="form-control @error('folio_acta') is-invalid @enderror"
                                    placeholder="Ej. ACTA-ORD-2026-04" value="{{ old('folio_acta') }}" required>
                                @error('folio_acta')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Fecha de la Baja*</label>
                                <input type="date" name="fecha_baja" class="form-control"
                                    value="{{ old('fecha_baja', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Documento Soporte Digital (PDF/Img)</label>
                                <input type="file" name="documento_soporte"
                                    class="form-control @error('documento_soporte') is-invalid @enderror">
                                @error('documento_soporte')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold small">Dictamen Técnico / Justificación*</label>
                                <textarea name="dictamen_tecnico" rows="3"
                                    class="form-control @error('dictamen_tecnico') is-invalid @enderror"
                                    placeholder="Indicar el dictamen técnico o los motivos por los cuales el activo no resulta costeable o útil..."
                                    required>{{ old('dictamen_tecnico') }}</textarea>
                                @error('dictamen_tecnico')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('bajas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-danger px-4">Procesar Baja Patrimonial</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection