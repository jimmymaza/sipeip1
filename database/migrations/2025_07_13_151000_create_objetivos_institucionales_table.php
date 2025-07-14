<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('objetivos_institucionales', function (Blueprint $table) {
            $table->id('IdObjetivo');
            $table->string('NombreObjetivo', 255);
            $table->text('Descripcion');
            $table->date('FechaCreacion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('objetivos_institucionales');
    }
};
