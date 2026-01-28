<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('treatment_plans', function (Blueprint $table) {
            $table->boolean('aceptado')->default(false)->after('estatus');
            $table->string('firma_paciente')->nullable()->after('aceptado');
            $table->timestamp('fecha_aceptacion')->nullable()->after('firma_paciente');
        });
    }

    public function down()
    {
        Schema::table('treatment_plans', function (Blueprint $table) {
            $table->dropColumn([
                'aceptado',
                'firma_paciente',
                'fecha_aceptacion'
            ]);
        });
    }

};
