<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jugadoresModelo extends Model
{
    protected $table = 'jugadores';
    protected $primaryKey = 'id_jugador';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_jugador',
        'nombre_jugador',
        'id_equipo',
        'posicion',
        'numero_camiseta',
        'estado',
    ];
}
