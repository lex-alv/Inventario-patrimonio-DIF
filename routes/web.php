<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\ResguardoController;
use App\Http\Controllers\BajaBienController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ImportacionBienController;

// Importador masivo de censo patrimonial
Route::get('bienes/importar', [ImportacionBienController::class, 'create'])->name('bienes.importar');
Route::post('bienes/importar', [ImportacionBienController::class, 'store'])->name('bienes.importar.store');

// Rutas públicas de Login
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (Requieren inicio de sesión)
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Reportes e Impresiones
    Route::get('bienes/reporte-general-pdf', [BienController::class, 'reporteGeneralPdf'])->name('bienes.reporteGeneralPdf');
    Route::get('bienes/imprimir-etiquetas', [BienController::class, 'imprimirEtiquetas'])->name('bienes.imprimirEtiquetas');
    Route::get('bienes-buscar', [BienController::class, 'buscarPorNumero'])->name('bienes.buscar');
    Route::get('escaner-qr', fn() => view('escaner'))->name('escaner');
    Route::get('resguardos/{resguardo}/pdf', [ResguardoController::class, 'descargarPdf'])->name('resguardos.pdf');

    // Módulos operativos
    Route::resource('bienes', BienController::class);
    Route::resource('resguardos', ResguardoController::class)->except(['edit', 'update', 'destroy']);
    Route::resource('empleados', EmpleadoController::class)->only(['index', 'show']);

    // Módulo exclusivo de Administrador / Contraloría (Bajas y Desincorporaciones)
    Route::middleware('rol:admin')->group(function () {
        Route::resource('bajas', BajaBienController::class)->only(['index', 'create', 'store']);
    });
});