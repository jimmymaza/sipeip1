<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('trazabilidad', function (Blueprint $table) {
            $table->id();
            $table->string('Entidad');
            $table->text('Accion');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('trazabilidad');
    }
};
