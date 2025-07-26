<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration
{
    public function up()
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_indicador');
            $table->year('anio');
            $table->decimal('valor_objetivo', 12, 2);
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamp('fecha_registro')->useCurrent();

            $table->foreign('id_indicador')->references('id')->on('indicadores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('metas');
    }
}
