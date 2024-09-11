<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;


    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'numero_carnet',
        'estado',
    ];
    // Relaciones
    public function socios()
    {
        return $this->hasMany(Socio::class);
    }
}
