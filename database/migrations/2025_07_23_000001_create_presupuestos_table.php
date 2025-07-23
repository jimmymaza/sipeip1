<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestosTable extends Migration
{
    public function up(): void
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->unsignedBigInteger('programa_id')->nullable();
            $table->unsignedBigInteger('proyecto_id')->nullable();
            $table->decimal('monto', 12, 2);
            $table->string('fuente_financiamiento')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('anio')->nullable();
            $table->string('estado', 20)->default('activo');
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('planes')->onDelete('set null');
            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('set null');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presupuestos');
    }
}
