<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('objetivos_pnd', function (Blueprint $table) {
            $table->id('IdObjetivo');
            $table->string('CodigoPND', 20);
            $table->string('NombrePND', 255);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('objetivos_pnd');
    }
};
