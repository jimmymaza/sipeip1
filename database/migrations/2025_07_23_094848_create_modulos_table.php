<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulosTable extends Migration
{
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->id('IdModulo'); // bigint unsigned auto_increment primary key
            $table->string('NombreModulo'); // coincide con el modelo
            // No timestamps porque en el modelo están desactivados
        });
    }

    public function down()
    {
        Schema::dropIfExists('modulos');
    }
}
