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
    Schema::table('ortodoncias', function (Blueprint $table) {

        // Paso 1
        $table->text('diagnostico')->nullable()->after('estado');

        // Pasos clínicos (fechas = hitos)
        $table->date('fecha_profilaxis')->nullable();
        $table->date('fecha_colocacion')->nullable();
        $table->date('fecha_retiro')->nullable();
        $table->date('fecha_retenedores')->nullable();
        $table->date('fecha_fin')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
public function down()
{
    Schema::table('ortodoncias', function (Blueprint $table) {
        $table->dropColumn([
            'diagnostico',
            'fecha_profilaxis',
            'fecha_colocacion',
            'fecha_retiro',
            'fecha_retenedores',
            'fecha_fin',
        ]);
    });
}

};
