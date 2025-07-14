<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('IdUsuario'); // PK auto incremental
            $table->string('Cedula', 10)->unique();
            $table->string('Nombre', 100);
            $table->string('Apellido', 100);
            $table->string('Correo', 255)->unique();
            $table->string('Telefono', 20)->nullable();
            $table->string('Clave', 255);
            $table->unsignedBigInteger('IdInstitucion');
            $table->unsignedInteger('IdRol');
            $table->date('FechaCreacion');
            $table->timestamps();

            // Foreign keys
            $table->foreign('IdInstitucion')->references('IdInstitucion')->on('instituciones')->onDelete('cascade');
            $table->foreign('IdRol')->references('IdRol')->on('rol')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
