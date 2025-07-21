<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanesTable extends Migration
{
    public function up()
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 255);
            $table->text('descripcion');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->date('fecha_inicio');  // Recomendado que no sea nullable si es requerido
            $table->date('fecha_fin');     // Igual que arriba, para validar mejor en backend
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('planes');
    }
}

