<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nombre_categoria',
        'descripcion',
        'edad_minima', 
        'edad_maxima'
    ];

    // Relación con equipos 
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id_categoria', 'id_categoria');
    }

    public function getRangoEdadAttribute()
    {
        return $this->edad_minima . ' - ' . $this->edad_maxima . ' años';
    }

    public function getCategoriaCompletaAttribute()
    {
        return $this->nombre_categoria . ' (' . $this->rango_edad . ')';
    }

    // SCOPE búsqueda
    public function scopeSearch($query, $search)
    {
        return $query->where('nombre_categoria', 'LIKE', "%{$search}%")
                    ->orWhere('descripcion', 'LIKE', "%{$search}%")
                    ->orWhere('edad_minima', 'LIKE', "%{$search}%")
                    ->orWhere('edad_maxima', 'LIKE', "%{$search}%");
    }
}