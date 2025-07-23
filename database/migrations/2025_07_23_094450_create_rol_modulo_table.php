<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolModuloTable extends Migration
{
    public function up()
    {
        Schema::create('rol_modulo', function (Blueprint $table) {
            $table->unsignedBigInteger('IdRol');
            $table->unsignedBigInteger('IdModulo');
            $table->boolean('AccesoCompleto')->default(false);

            $table->primary(['IdRol', 'IdModulo']);

            // Llaves foráneas
            $table->foreign('IdRol')->references('IdRol')->on('rol')->onDelete('cascade');
            $table->foreign('IdModulo')->references('IdModulo')->on('modulos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rol_modulo');
    }
}
