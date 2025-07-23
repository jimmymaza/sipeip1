<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVinculacionesTable extends Migration
{
    public function up()
    {
        Schema::create('vinculaciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // ODS, OEI, OPND
            $table->string('nombre');
            $table->text('descripcion')->nullable();

            // Nuevas columnas FK para las relaciones
            $table->unsignedBigInteger('objetivo_institucional_id')->nullable();
            $table->unsignedBigInteger('indicador_id')->nullable();
            $table->unsignedBigInteger('meta_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('objetivo_institucional_id')->references('id')->on('objetivos_institucionales')->onDelete('set null');
            $table->foreign('indicador_id')->references('id')->on('indicadores')->onDelete('set null');
            $table->foreign('meta_id')->references('id')->on('metas')->onDelete('set null');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vinculaciones');
    }
}

