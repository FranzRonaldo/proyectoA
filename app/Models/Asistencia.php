<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencias';

    protected $fillable = [
        'socio_id',
        'actividad_id',
        'asistio',
        'multa_aplicada',
    ];
    
    protected $casts = [
        'asistio' => 'boolean',
        'multa_aplicada' => 'boolean',
    ];

    //relaciones
    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }
}
