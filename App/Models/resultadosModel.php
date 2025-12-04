<?php

namespace App\Models;

use Illuminate\Database\Eloquent\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resultadosModel extends Model
{
    protected $table = 'resultados';
    protected $primaryKey = 'id_resultado';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable=[
        'id_resultado',
        'id_encuentro',
        'id_torneo',
        'goles_local',
        'goles_visitante',
        'id_equipo',
        'id_equipo_local',
        'id_equipo_visitante',
        'observaciones'
    ];
}