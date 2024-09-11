<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'consumo_id',
        'monto_pagado',
        'fecha_pago',
    ];

    protected $casts = [
        'monto_pagado' => 'decimal:2',
        'fecha_pago' => 'date',
    ];

    // Relaciones
    public function consumo()
    {
        return $this->belongsTo(Consumo::class);
    }
}
