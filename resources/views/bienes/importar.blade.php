@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="bi bi-file-earmark-spreadsheet me-2" style="color: var(--gov-accent-teal);"></i>Carga Masiva de Activos (Censo Inicial)
                        </h5>
                        <span class="small text-muted">Importa listas de inventario físico generadas desde Excel en formato CSV</span>
                    </div>
                    <a href="{{ route('bienes.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
                <div class="card-body p-4">

                    <div class="alert alert-info small mb-4">
                        <div class="w-100">
                            <h6 class="fw-bold mb-2 d-flex align-items-center">
                                <i class="bi bi-info-circle-fill me-2 fs-6"></i>Estructura requerida de las columnas:
                            </h6>
                            <div class="p-2 bg-white rounded border font-mono-num mb-2 text-dark" style="font-size: 0.75rem;">
                                No. Inventario, Código Cuenta CONAC, Nombre de Área, Descripción, Marca, Modelo, Serie, Costo, Estado
                            </div>
                            <div class="text-muted" style="font-size: 0.75rem;">
                                <strong>Ejemplo:</strong> <span class="font-mono-num text-dark">SMDIF-010, 1241, Coordinación Administrativa, Silla secretarial ergonómica, Herman Miller, Setu, SN9921, 3500.00, Bueno</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('bienes.importar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Seleccionar Archivo CSV (.csv)*</label>
                            <input type="file" name="archivo_csv"
                                class="form-control @error('archivo_csv') is-invalid @enderror" accept=".csv,text/csv"
                                required>
                            @error('archivo_csv')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('bienes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-cloud-upload me-1"></i>Procesar e Importar Censo
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection