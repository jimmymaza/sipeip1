<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObjetivoIdToMetasTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('metas', 'objetivo_id')) {
            Schema::table('metas', function (Blueprint $table) {
                $table->unsignedBigInteger('objetivo_id')->nullable()->after('id_indicador');

                // Si tienes tabla 'objetivos_institucionales'
                $table->foreign('objetivo_id')->references('id')->on('objetivos_institucionales')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('metas', 'objetivo_id')) {
            Schema::table('metas', function (Blueprint $table) {
                $table->dropForeign(['objetivo_id']);
                $table->dropColumn('objetivo_id');
            });
        }
    }
}
