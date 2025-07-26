<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVinculacionesTable extends Migration
{
    public function up()
    {
        Schema::create('vinculaciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // ODS, OEI, OPND
            $table->string('nombre');
            $table->text('descripcion')->nullable();

            // Columnas para relaciones (sin claves foráneas aún para evitar errores)
            $table->unsignedBigInteger('objetivo_institucional_id')->nullable();
            $table->unsignedBigInteger('indicador_id')->nullable();
            $table->unsignedBigInteger('meta_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();

            $table->timestamps();
        });

       
        Schema::table('vinculaciones', function (Blueprint $table) {
            $table->foreign('objetivo_institucional_id')
                  ->references('id')->on('objetivos_institucionales')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('vinculaciones', function (Blueprint $table) {
            // Eliminar clave foránea antes de eliminar tabla
            $table->dropForeign(['objetivo_institucional_id']);
        });

        Schema::dropIfExists('vinculaciones');
    }
}
