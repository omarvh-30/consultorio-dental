<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('treatment_plans', function (Blueprint $table) {

            if (!Schema::hasColumn('treatment_plans', 'aceptado')) {
                $table->boolean('aceptado')->default(false)->after('estatus');
            }

            if (!Schema::hasColumn('treatment_plans', 'firma_paciente')) {
                $table->string('firma_paciente')->nullable()->after('aceptado');
            }

            if (!Schema::hasColumn('treatment_plans', 'fecha_aceptacion')) {
                $table->timestamp('fecha_aceptacion')->nullable()->after('firma_paciente');
            }
        });
    }

    public function down()
    {
        Schema::table('treatment_plans', function (Blueprint $table) {

            if (Schema::hasColumn('treatment_plans', 'aceptado')) {
                $table->dropColumn('aceptado');
            }

            if (Schema::hasColumn('treatment_plans', 'firma_paciente')) {
                $table->dropColumn('firma_paciente');
            }

            if (Schema::hasColumn('treatment_plans', 'fecha_aceptacion')) {
                $table->dropColumn('fecha_aceptacion');
            }
        });
    }
};
