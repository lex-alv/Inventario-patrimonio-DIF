<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BajaBien extends Model
{
    protected $table = 'bajas_bienes';

    protected $fillable = [
        'bien_id',
        'tipo_baja',
        'folio_acta',
        'fecha_baja',
        'dictamen_tecnico',
        'documento_soporte_url',
    ];

    public function bien(): BelongsTo
    {
        return $this->belongsTo(Bien::class, 'bien_id');
    }
}