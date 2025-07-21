<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetivosInstitucionalesTable extends Migration
{
    public function up()
    {
        Schema::create('objetivos_institucionales', function (Blueprint $table) {
            $table->id();
            
            // Código único para el objetivo, máximo 20 caracteres
            $table->string('codigo', 20)->unique()->comment('Código único del objetivo');

            // Nombre descriptivo del objetivo
            $table->string('nombre', 255)->comment('Nombre del objetivo');

            // Descripción detallada
            $table->text('descripcion')->comment('Descripción del objetivo');

            // Estado para controlar si está activo o inactivo
            $table->enum('estado', ['activo', 'inactivo'])->default('activo')->comment('Estado del objetivo');

            // Fecha opcional de registro o entrada en vigencia
            $table->date('fecha_registro')->nullable()->comment('Fecha de registro');

            // Campo para diferenciar tipo: institucional, plan_nacional, ods
            $table->string('tipo', 50)->index()->comment('Tipo de objetivo');

            // Timestamps: created_at y updated_at
            $table->timestamps();

            // Soft deletes para borrado lógico (opcional)
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('objetivos_institucionales');
    }
}
