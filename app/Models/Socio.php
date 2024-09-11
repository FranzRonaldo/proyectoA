<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Socio extends Model
{
    use HasFactory;

    protected $table = 'socios';

    protected $fillable = [
        'red',
        'codigo',
        'ubicacion',
        'fecha_ingreso',
        'estado',
        'persona_id',
        'identificador_socio', // Nuevo campo
    ];

    // Indicar que 'fecha_ingreso' es una fecha
    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    // Definir la relación con el modelo Persona
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    // Definir la relación con el modelo Consumo
    public function consumos()
    {
        return $this->hasMany(Consumo::class);
    }

    // Relación con el modelo Asistencia
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    // Generar automáticamente 'identificador_socio' antes de guardar el modelo
    protected static function booted()
    {
        static::creating(function ($socio) {
            if (is_null($socio->identificador_socio)) {
                $lastId = self::max('id') ?? 0;
                $socio->identificador_socio = 'A-' . ($lastId + 1);
            }
        });
    }
}
