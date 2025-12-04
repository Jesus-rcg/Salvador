<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; 

    protected $fillable = [
        'id_usuario',
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'id_rol',
        'fecha_registro',
        'fecha_nacimiento',
        'estado'
    ];

    protected $casts = [
        'fecha_registro' => 'date',
        'fecha_nacimiento' => 'date',
    ];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_usuario', 'id_usuario');
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
