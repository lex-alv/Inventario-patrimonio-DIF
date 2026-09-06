@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-file-earmark-plus me-2"></i>Alta de Bien Mueble
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('bienes.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">No. de Inventario (Etiqueta)*</label>
                                <input type="text" name="numero_inventario"
                                    class="form-control @error('numero_inventario') is-invalid @enderror"
                                    value="{{ old('numero_inventario') }}" placeholder="Ej. DIF-2026-0001" required>
                                @error('numero_inventario')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Cuenta Contable Armonizada*</label>
                                <select name="cuenta_contable_id"
                                    class="form-select @error('cuenta_contable_id') is-invalid @enderror" required>
                                    <option value="">Seleccione una cuenta...</option>
                                    @foreach($cuentas as $cuenta)
                                        <option value="{{ $cuenta->id }}" {{ old('cuenta_contable_id') == $cuenta->id ? 'selected' : '' }}>
                                            {{ $cuenta->codigo }} - {{ $cuenta->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cuenta_contable_id')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Área de Adscripción*</label>
                                <select name="unidad_administrativa_id"
                                    class="form-select @error('unidad_administrativa_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un área...</option>
                                    @foreach($unidades as $unidad)
                                        <option value="{{ $unidad->id }}" {{ old('unidad_administrativa_id') == $unidad->id ? 'selected' : '' }}>
                                            {{ $unidad->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unidad_administrativa_id')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold small">Descripción Detallada del Bien*</label>
                                <textarea name="descripcion" rows="2"
                                    class="form-control @error('descripcion') is-invalid @enderror"
                                    placeholder="Indicar características físicas, color, dimensiones o material..."
                                    required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Marca</label>
                                <input type="text" name="marca" class="form-control" value="{{ old('marca') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Modelo</label>
                                <input type="text" name="modelo" class="form-control" value="{{ old('modelo') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Número de Serie</label>
                                <input type="text" name="numero_serie" class="form-control"
                                    value="{{ old('numero_serie') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">No. Factura / Soporte</label>
                                <input type="text" name="factura_numero" class="form-control"
                                    value="{{ old('factura_numero') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Fecha de Adquisición</label>
                                <input type="date" name="fecha_adquisicion" class="form-control"
                                    value="{{ old('fecha_adquisicion') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Costo de Adquisición ($)*</label>
                                <input type="number" step="0.01" name="costo_adquisicion"
                                    class="form-control @error('costo_adquisicion') is-invalid @enderror"
                                    value="{{ old('costo_adquisicion', '0.00') }}" required>
                                @error('costo_adquisicion')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold small">Tipo de Incorporación*</label>
                                <select name="tipo_adquisicion" class="form-select" required>
                                    <option value="Compra">Compra</option>
                                    <option value="Donación">Donación</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Inventario Inicial">Inventario Inicial</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Estado de Conservación*</label>
                                <select name="estado_conservacion" class="form-select" required>
                                    <option value="Bueno">Bueno</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Malo">Malo</option>
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-bold small">Observaciones Adicionales</label>
                                <input type="text" name="observaciones" class="form-control"
                                    value="{{ old('observaciones') }}">
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('bienes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4">Guardar Activo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection