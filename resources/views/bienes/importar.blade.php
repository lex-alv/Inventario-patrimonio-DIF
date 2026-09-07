@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-secondary">
                        <i class="bi bi-file-earmark-spreadsheet me-2 text-success"></i>Carga Masiva de Activos (Censo
                        Inicial)
                    </h5>
                    <small class="text-muted">Importa listas de inventario físico generadas desde Excel en formato
                        CSV</small>
                </div>
                <div class="card-body p-4">

                    <div class="alert alert-light border small mb-4">
                        <h6 class="fw-bold mb-2"><i class="bi bi-info-circle me-1 text-primary"></i>Estructura requerida de
                            las columnas:</h6>
                        <code>No. Inventario, Código Cuenta CONAC, Nombre de Área, Descripción, Marca, Modelo, Serie, Costo, Estado</code>
                        <div class="text-muted mt-2">Ejemplo:
                            <code>SMDIF-010, 1241, Coordinación Administrativa, Silla secretarial ergonómica, Herman Miller, Setu, SN9921, 3500.00, Bueno</code>
                        </div>
                    </div>

                    <form action="{{ route('bienes.importar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Archivo CSV (.csv)*</label>
                            <input type="file" name="archivo_csv"
                                class="form-control @error('archivo_csv') is-invalid @enderror" accept=".csv,text/csv"
                                required>
                            @error('archivo_csv')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('bienes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-cloud-upload me-1"></i>Procesar e Importar Censo
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection