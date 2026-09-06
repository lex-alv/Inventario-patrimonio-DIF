<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bien extends Model
{
    // Forzamos el nombre de la tabla en español
    protected $table = 'bienes';

    protected $fillable = [
        'numero_inventario',
        'cuenta_contable_id',
        'unidad_administrativa_id',
        'descripcion',
        'marca',
        'modelo',
        'numero_serie',
        'factura_numero',
        'fecha_adquisicion',
        'costo_adquisicion',
        'tipo_adquisicion',
        'estado_conservacion',
        'estatus',
        'observaciones',
        'codigo_qr',
    ];

    public function cuentaContable(): BelongsTo
    {
        return $this->belongsTo(CuentaContable::class, 'cuenta_contable_id');
    }

    public function unidadAdministrativa(): BelongsTo
    {
        return $this->belongsTo(UnidadAdministrativa::class, 'unidad_administrativa_id');
    }

    public function detallesResguardos(): HasMany
    {
        return $this->hasMany(DetalleResguardo::class, 'bien_id');
    }

    public function baja(): HasOne
    {
        return $this->hasOne(BajaBien::class, 'bien_id');
    }
}