<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('objetivos_ods', function (Blueprint $table) {
            $table->id('IdObjetivo');
            $table->string('CodigoODS', 20);
            $table->string('NombreODS', 255);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('objetivos_ods');
    }
};
