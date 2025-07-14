<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id('IdProyecto');
            $table->string('NombreProyecto', 255);
            $table->text('Descripcion');
            $table->date('FechaInicio');
            $table->date('FechaFin');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('proyectos');
    }
};
