<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadoresTable extends Migration
{
    public function up()
    {
        Schema::create('indicadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alineacion'); // relación con vinculaciones
            $table->string('codigo', 50)->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('unidad_medida', 100)->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamps();

            $table->foreign('id_alineacion')->references('id')->on('vinculaciones')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('indicadores', function (Blueprint $table) {
            $table->dropForeign(['id_alineacion']);
        });

        Schema::dropIfExists('indicadores');
    }
}
