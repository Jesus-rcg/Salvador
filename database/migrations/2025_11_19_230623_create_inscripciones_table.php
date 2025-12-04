<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('inscripciones')) {
            Schema::create('inscripciones', function (Blueprint $table) {
                $table->id('id_inscripcion');
                $table->integer('id_torneo')->unsigned();
                $table->string('id_usuario', 20);
                $table->date('fecha_inscripcion');
                $table->enum('estado', ['Inscrito', 'Participando', 'Finalizado', 'Retirado'])->default('Inscrito');
                $table->text('observaciones')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // No dropear la tabla si ya existe y tiene datos
        // Schema::dropIfExists('inscripciones');
    }
};