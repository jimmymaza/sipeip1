<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdMetaToIndicadoresTable extends Migration
{
    public function up()
    {
        Schema::table('indicadores', function (Blueprint $table) {
         
            $table->unsignedBigInteger('id_meta')->nullable()->after('id_alineacion');

        
            $table->foreign('id_meta')->references('id')->on('metas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('indicadores', function (Blueprint $table) {
            // Primero eliminamos la foreign key si la agregamos
            $table->dropForeign(['id_meta']);
            $table->dropColumn('id_meta');
        });
    }
}
