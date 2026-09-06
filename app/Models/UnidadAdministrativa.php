<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnidadAdministrativa extends Model
{
    protected $table = 'unidades_administrativas';

    protected $fillable = [
        'clave',
        'nombre',
        'titular_area',
    ];

    public function empleados(): HasMany
    {
        return $this->hasMany(Empleado::class, 'unidad_administrativa_id');
    }

    public function bienes(): HasMany
    {
        return $this->hasMany(Bien::class, 'unidad_administrativa_id');
    }
}