<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BienController;
use App\Http\Controllers\ResguardoController;
use App\Http\Controllers\BajaBienController;

Route::resource('bienes', BienController::class);
Route::resource('resguardos', ResguardoController::class)->except(['edit', 'update', 'destroy']);
Route::get('resguardos/{resguardo}/pdf', [ResguardoController::class, 'descargarPdf'])
    ->name('resguardos.pdf');
Route::resource('bajas', BajaBienController::class)->only(['index', 'create', 'store']);
Route::get('/', function () {
    return redirect()->route('bienes.index');
});
