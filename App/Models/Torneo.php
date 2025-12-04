<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    protected $table = 'torneos';
    protected $primaryKey = 'id_torneo';

    protected $fillable = [
        'nombre_torneo',
        'fecha_inicio',
        'fecha_fin',
        'ciudad',
        'id_categoria',
        'id_usuario',
        'estado',
        'max_equipos',
        'tipo_torneo',
    ];

    public $timestamps = false;
}