<?php

namespace App\Models;

use Illuminate\Database\Eloquent\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resultadosModel extends Model
{
    protected $table = 'premiacion';
    protected $primaryKey = 'id_premiacion';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable=[
        'id_premiacion',
        'id_torneo',
        'id_equipo',
        'posicion',
        'premio',
        'descripcion'
    ];
}