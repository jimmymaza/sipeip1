<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlineacionObjetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alineacion_objetivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('objetivo_id');
            $table->unsignedBigInteger('objetivo_alineado_id');
            $table->string('tipo_alineacion')->nullable(); // <-- nueva columna, nullable por si acaso
            $table->timestamps();

            // Llaves foráneas hacia objetivos_institucionales.id
            $table->foreign('objetivo_id')->references('id')->on('objetivos_institucionales')->onDelete('cascade');
            $table->foreign('objetivo_alineado_id')->references('id')->on('objetivos_institucionales')->onDelete('cascade');

            // Índice para consultas rápidas (opcional)
            $table->index('tipo_alineacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alineacion_objetivos');
    }
}
