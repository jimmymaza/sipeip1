<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('revision', function (Blueprint $table) {
            $table->id('IdRevision');
            $table->string('Descripcion', 255);
            $table->date('FechaRevision');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revision');
    }
};
