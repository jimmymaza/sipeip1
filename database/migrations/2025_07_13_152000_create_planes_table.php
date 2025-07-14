<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('planes', function (Blueprint $table) {
            $table->id('IdPlan');
            $table->string('NombrePlan', 255);
            $table->text('Descripcion');
            $table->date('FechaCreacion');
            $table->string('Estado', 50);
            $table->string('Cedula', 10); // FK usuarios
            $table->unsignedBigInteger('IdRevision')->nullable(); // FK revision
            $table->unsignedBigInteger('IdObjetivo')->nullable(); // FK objetivos
            $table->timestamps();

            $table->foreign('Cedula')->references('Cedula')->on('usuarios')->onDelete('cascade');
            $table->foreign('IdRevision')->references('IdRevision')->on('revision')->onDelete('set null');
            $table->foreign('IdObjetivo')->references('IdObjetivo')->on('objetivos_institucionales')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};
