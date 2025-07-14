<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alineacion_objetivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('objetivo_institucional_id');
            $table->unsignedBigInteger('objetivo_pnd_id');
            $table->unsignedBigInteger('objetivo_ods_id');
            $table->timestamps();

            $table->foreign('objetivo_institucional_id')->references('IdObjetivo')->on('objetivos_institucionales')->onDelete('cascade');
            $table->foreign('objetivo_pnd_id')->references('IdObjetivo')->on('objetivos_pnd')->onDelete('cascade');
            $table->foreign('objetivo_ods_id')->references('IdObjetivo')->on('objetivos_ods')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('alineacion_objetivos');
    }
};
