<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';
    protected $primaryKey = 'id_equipo';
    public $incrementing = true; 
    protected $keyType = 'int';  
    public $timestamps = false;
    
    protected $fillable = [
        'nombre_equipo',
        'ciudad',
        'id_categoria', 
        'escudo_url',
        'estado',
    ];

    // relacion con categorias 
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}
