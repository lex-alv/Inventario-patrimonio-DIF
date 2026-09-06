<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resguardo extends Model
{
    protected $table = 'resguardos';

    protected $fillable = [
        'folio_resguardo',
        'empleado_id',
        'fecha_emision',
        'fecha_cierre',
        'estatus',
        'ruta_cedula_pdf',
    ];

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleResguardo::class, 'resguardo_id');
    }
}