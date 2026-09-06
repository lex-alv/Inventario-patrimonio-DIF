<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'numero_empleado',
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'cargo',
        'unidad_administrativa_id',
        'correo_institucional',
        'estatus',
    ];

    public function unidadAdministrativa(): BelongsTo
    {
        return $this->belongsTo(UnidadAdministrativa::class, 'unidad_administrativa_id');
    }

    public function resguardos(): HasMany
    {
        return $this->hasMany(Resguardo::class, 'empleado_id');
    }

    // Atributo dinámico para obtener el nombre completo
    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombre} {$this->primer_apellido} {$this->segundo_apellido}");
    }
}