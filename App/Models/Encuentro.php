<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuentro extends Model
{
    protected $table = 'encuentros';
    protected $primaryKey = 'id_encuentro';
    public $timestamps = false;

    protected $fillable = [
        'id_fecha',
        'hora',
        'id_torneo',
        'id_lugar',
        'id_arbitro',
        'id_equipo_local',
        'id_equipo_visitante',
        'estado'
    ];

   
    public function fecha() { return $this->belongsTo(fechasModelo::class, 'id_fecha', 'id_fecha'); }
    public function torneo() { return $this->belongsTo(Torneo::class, 'id_torneo', 'id_torneo'); }
    public function lugar() { return $this->belongsTo(lugaresModelo::class, 'id_lugar', 'id_lugar'); }
    public function arbitro() { return $this->belongsTo(arbitrosModelo::class, 'id_arbitro', 'id_arbitro'); }
    public function equipoLocal() { return $this->belongsTo(Equipo::class, 'id_equipo_local', 'id_equipo'); }
    public function equipoVisitante() { return $this->belongsTo(Equipo::class, 'id_equipo_visitante', 'id_equipo'); }

    
    public function getNombreArbitroAttribute()
    {
        return $this->arbitro ? $this->arbitro->id_usuario : 'Sin árbitro';
    }
}
