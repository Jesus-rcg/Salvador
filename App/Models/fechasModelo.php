<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fechasModelo extends Model
{
    use HasFactory;

    protected $table = 'fechas';
    protected $primaryKey = 'id_fecha';
    public $timestamps = false;

    protected $fillable = [
        'id_torneo',
        'fecha'
    ];

    // Relación con encuentros
    public function encuentros()
    {
        return $this->hasMany(Encuentro::class, 'id_fecha', 'id_fecha');
    }
}
 