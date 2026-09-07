@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="bi bi-file-earmark-plus me-2" style="color: var(--gov-primary);"></i>Alta de Bien Mueble Patrimonial
                        </h5>
                        <span class="small text-muted">Incorporación formal al catálogo de activos del SMDIF</span>
                    </div>
                    <a href="{{ route('bienes.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Regresar al Padrón
                    </a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('bienes.store') }}" method="POST">
                        @csrf

                        <!-- Sección 1: Datos de Identificación y Clasificación -->
                        <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                            <i class="bi bi-tag me-1" style="color: var(--gov-primary);"></i>1. Identificación y Clasificación Contable
                        </h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">No. de Inventario (Etiqueta)*</label>
                                <input type="text" name="numero_inventario"
                                    class="form-control font-mono-num @error('numero_inventario') is-invalid @enderror"
                                    value="{{ old('numero_inventario') }}" placeholder="Ej. SMDIF-2026-0001" required>
                                @error('numero_inventario')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Cuenta CONAC Armonizada*</label>
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
                                <label class="form-label">Área de Adscripción*</label>
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
                                <label class="form-label">Descripción Detallada del Activo*</label>
                                <textarea name="descripcion" rows="2"
                                    class="form-control @error('descripcion') is-invalid @enderror"
                                    placeholder="Indicar características físicas, color, dimensiones o material..."
                                    required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Sección 2: Especificaciones Técnicas y Adquisición -->
                        <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                            <i class="bi bi-gear me-1" style="color: var(--gov-primary);"></i>2. Especificaciones Técnicas y de Adquisición
                        </h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Marca</label>
                                <input type="text" name="marca" class="form-control" value="{{ old('marca') }}" placeholder="Ej. Dell, HP, Muebles Troncoso">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Modelo</label>
                                <input type="text" name="modelo" class="form-control" value="{{ old('modelo') }}" placeholder="Ej. OptiPlex 7090">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Número de Serie</label>
                                <input type="text" name="numero_serie" class="form-control font-mono-num"
                                    value="{{ old('numero_serie') }}" placeholder="Ej. SN8839219A">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">No. Factura / Soporte</label>
                                <input type="text" name="factura_numero" class="form-control font-mono-num"
                                    value="{{ old('factura_numero') }}" placeholder="Ej. FAC-2026-99">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Fecha de Adquisición</label>
                                <input type="date" name="fecha_adquisicion" class="form-control"
                                    value="{{ old('fecha_adquisicion') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Costo de Adquisición ($)*</label>
                                <input type="number" step="0.01" name="costo_adquisicion"
                                    class="form-control font-mono-num @error('costo_adquisicion') is-invalid @enderror"
                                    value="{{ old('costo_adquisicion', '0.00') }}" required>
                                @error('costo_adquisicion')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tipo de Incorporación*</label>
                                <select name="tipo_adquisicion" class="form-select" required>
                                    <option value="Compra" {{ old('tipo_adquisicion') == 'Compra' ? 'selected' : '' }}>Compra</option>
                                    <option value="Donación" {{ old('tipo_adquisicion') == 'Donación' ? 'selected' : '' }}>Donación</option>
                                    <option value="Transferencia" {{ old('tipo_adquisicion') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                                    <option value="Inventario Inicial" {{ old('tipo_adquisicion') == 'Inventario Inicial' ? 'selected' : '' }}>Inventario Inicial</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Estado de Conservación*</label>
                                <select name="estado_conservacion" class="form-select" required>
                                    <option value="Bueno" {{ old('estado_conservacion') == 'Bueno' ? 'selected' : '' }}>Bueno</option>
                                    <option value="Regular" {{ old('estado_conservacion') == 'Regular' ? 'selected' : '' }}>Regular</option>
                                    <option value="Malo" {{ old('estado_conservacion') == 'Malo' ? 'selected' : '' }}>Malo</option>
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">Observaciones Adicionales</label>
                                <input type="text" name="observaciones" class="form-control"
                                    value="{{ old('observaciones') }}" placeholder="Notas complementarias sobre el resguardo o estado físico">
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('bienes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-1"></i>Guardar Activo Patrimonial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection