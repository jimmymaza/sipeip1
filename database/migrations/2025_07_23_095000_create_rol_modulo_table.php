<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolModuloTable extends Migration
{
    public function up()
    {
        Schema::create('rol_modulo', function (Blueprint $table) {
            // Según tu tabla 'rol', IdRol es int unsigned (4 bytes), así que usamos unsignedInteger
            $table->unsignedInteger('IdRol');
            // Según tu tabla 'modulos', IdModulo es bigint unsigned (8 bytes), usamos unsignedBigInteger
            $table->unsignedBigInteger('IdModulo');
            $table->boolean('AccesoCompleto')->default(false);

            $table->primary(['IdRol', 'IdModulo']);

            // Llaves foráneas con tipos compatibles
            $table->foreign('IdRol')->references('IdRol')->on('rol')->onDelete('cascade');
            $table->foreign('IdModulo')->references('IdModulo')->on('modulos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rol_modulo');
    }
}
