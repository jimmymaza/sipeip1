<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('instituciones', function (Blueprint $table) {
            $table->bigIncrements('IdInstitucion');
            $table->string('Nombre');
            $table->string('Codigo')->unique();
            $table->string('Subsector');
            $table->string('NivelGobierno');
            $table->boolean('Estado')->default(true);
            $table->timestamp('FechaCreacion')->useCurrent();
            $table->timestamp('FechaActualizacion')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instituciones');
    }
};
