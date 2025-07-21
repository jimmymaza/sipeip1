<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration
{
    public function up()
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre');
            $table->text('descripcion');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->unsignedBigInteger('objetivo_id');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->timestamps();

            $table->foreign('objetivo_id')->references('id')->on('objetivos_institucionales')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('metas');
    }
}

