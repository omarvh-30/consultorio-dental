<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('ortodoncias', function (Blueprint $table) {

            if (!Schema::hasColumn('ortodoncias', 'diagnostico')) {
                $table->text('diagnostico')->nullable()->after('estado');
            }

            $fechas = [
                'fecha_profilaxis',
                'fecha_colocacion',
                'fecha_retiro',
                'fecha_retenedores',
                'fecha_fin',
            ];

            foreach ($fechas as $fecha) {
                if (!Schema::hasColumn('ortodoncias', $fecha)) {
                    $table->date($fecha)->nullable();
                }
            }
        });
    }

    public function down()
    {
        Schema::table('ortodoncias', function (Blueprint $table) {

            $columnas = [
                'diagnostico',
                'fecha_profilaxis',
                'fecha_colocacion',
                'fecha_retiro',
                'fecha_retenedores',
                'fecha_fin',
            ];

            foreach ($columnas as $columna) {
                if (Schema::hasColumn('ortodoncias', $columna)) {
                    $table->dropColumn($columna);
                }
            }
        });
    }
};
