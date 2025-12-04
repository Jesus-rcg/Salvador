<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class arbitrosModelo extends Model
{
    protected $table = 'arbitros';
    protected $primaryKey = 'id_arbitro';
    public $timestamps = false;
}