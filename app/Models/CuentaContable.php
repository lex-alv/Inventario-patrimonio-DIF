<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CuentaContable extends Model
{
    protected $table = 'cuentas_contables';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
    ];

    public function bienes(): HasMany
    {
        return $this->hasMany(Bien::class, 'cuenta_contable_id');
    }
}