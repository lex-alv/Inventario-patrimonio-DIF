<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BienController;
use App\Http\Controllers\ResguardoController;
use App\Http\Controllers\BajaBienController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpleadoController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('bienes', BienController::class);
Route::resource('resguardos', ResguardoController::class)->except(['edit', 'update', 'destroy']);
Route::get('resguardos/{resguardo}/pdf', [ResguardoController::class, 'descargarPdf'])
    ->name('resguardos.pdf');
Route::resource('bajas', BajaBienController::class)->only(['index', 'create', 'store']);
Route::get('bienes-buscar', [BienController::class, 'buscarPorNumero'])->name('bienes.buscar');
Route::resource('empleados', EmpleadoController::class)->only(['index', 'show']);
Route::get('escaner-qr', function () {
    return view('escaner');
})->name('escaner');