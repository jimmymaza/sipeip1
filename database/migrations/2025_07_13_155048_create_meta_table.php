<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta', function (Blueprint $table) {
            $table->id('IdMeta');
            $table->string('NombreMeta', 255);
            $table->text('Descripcion');
            $table->string('TipoMeta', 100);
            $table->date('FechaInicio');
            $table->date('FechaFin');
            $table->string('Estado', 50);
            $table->unsignedBigInteger('IdObjetivo');
            $table->timestamps();

            // Clave foránea corregida
            $table->foreign('IdObjetivo')
                  ->references('IdObjetivo')
                  ->on('objetivos_institucionales') // ← nombre correcto
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta');
    }
};
