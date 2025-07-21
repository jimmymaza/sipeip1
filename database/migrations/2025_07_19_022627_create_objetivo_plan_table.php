<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetivoPlanTable extends Migration
{
    public function up()
    {
        Schema::create('objetivo_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objetivo_id')->constrained('objetivos_institucionales')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('planes')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['objetivo_id', 'plan_id']); // Evita duplicados
        });
    }

    public function down()
    {
        Schema::dropIfExists('objetivo_plan');
    }
}
