<?php

namespace App\Models;

use Illuminate\Database\Eloquent\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolesModelo extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_rol';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable=[
        'id_rol',
        'nombrerol',
        'descripcion'
    ];


}

