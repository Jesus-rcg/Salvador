<?php

namespace App\Models;

use Illuminate\Database\Eloquent\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolesModelo extends Model
{
    protected $table = 'posiciones';
    protected $primaryKey = 'id_posicion';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable=[
        'id_posicion',
        'id_torneo',
        'id_equipo',
        'pj',
        'pg',
        'pe',
        'pp',
        'gf',
        'gc',
        'gd',
        'puntos'


    ];

}

