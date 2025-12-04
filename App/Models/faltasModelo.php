<?php

namespace App\Models;

use Illuminate\Database\Eloquent\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faltasModelo extends Model
{
    protected $table = 'faltas';
    protected $primaryKey = 'id_falta';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable=[
        'id_falta',
        'id_encuentro',
        'id_jugador',
        'id_tipo_falta',
        "minuto",
        "tarjeta",
        "descripcion"
    ];
}
