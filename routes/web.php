<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BienController;
use App\Http\Controllers\ResguardoController;
use App\Http\Controllers\BajaBienController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpleadoController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rutas personalizadas de bienes (deben ir antes del Route::resource('bienes') para evitar colisiones con {biene})
Route::get('bienes/reporte-general-pdf', [BienController::class, 'reporteGeneralPdf'])
    ->name('bienes.reporteGeneralPdf');
Route::get('bienes-buscar', [BienController::class, 'buscarPorNumero'])->name('bienes.buscar');
Route::get('bienes/imprimir-etiquetas', [BienController::class, 'imprimirEtiquetas'])
    ->name('bienes.imprimirEtiquetas');

Route::resource('bienes', BienController::class);
Route::resource('resguardos', ResguardoController::class)->except(['edit', 'update', 'destroy']);
Route::get('resguardos/{resguardo}/pdf', [ResguardoController::class, 'descargarPdf'])
    ->name('resguardos.pdf');
Route::resource('bajas', BajaBienController::class)->only(['index', 'create', 'store']);
Route::resource('empleados', EmpleadoController::class)->only(['index', 'show']);

Route::get('escaner-qr', function () {
    return view('escaner');
})->name('escaner');