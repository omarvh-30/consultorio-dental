<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {

            $table->boolean('es_protesis')
                  ->default(false)
                  ->after('es_ortodoncia');

        });
    }

    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {

            $table->dropColumn('es_protesis');

        });
    }
};
