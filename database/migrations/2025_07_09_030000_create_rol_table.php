<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolTable extends Migration
{
    public function up()
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->increments('IdRol');
            $table->string('Nombre')->unique();
            $table->text('Descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rol');
    }
}

