<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleResguardo extends Model
{
    protected $table = 'detalle_resguardos';

    protected $fillable = [
        'resguardo_id',
        'bien_id',
        'fecha_asignacion',
        'fecha_devolucion',
        'observaciones_entrega',
        'observaciones_devolucion',
    ];

    public function resguardo(): BelongsTo
    {
        return $this->belongsTo(Resguardo::class, 'resguardo_id');
    }

    public function bien(): BelongsTo
    {
        return $this->belongsTo(Bien::class, 'bien_id');
    }
}