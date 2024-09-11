<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{   use HasFactory;

    protected $table = 'consumos';

    protected $fillable = [
        'socio_id',
        'mes',
        'anio',
        'consumo',
        'monto_cobrar',
        'total_pagado',
        'deuda',
        'estado_pago',
        'lectura_anterior',
        'lectura_actual',
    ];

    protected $casts = [
        'estado_pago' => 'boolean',
        'consumo' => 'decimal:2',
        'monto_cobrar' => 'decimal:2',
        'total_pagado' => 'decimal:2',
        'deuda' => 'decimal:2',
        'lectura_anterior' => 'decimal:2',
        'lectura_actual' => 'decimal:2',
    ];
    //relaciones
    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
