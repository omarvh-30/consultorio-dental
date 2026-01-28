<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {

            $campos = [
                'antecedentes_heredofamiliares',
                'antecedentes_patologicos',
                'antecedentes_no_patologicos',
                'tratamiento_medico',
                'enfermedades',
                'traumatismos',
                'transfusiones_cirugias',
                'motivo_consulta',
            ];

            foreach ($campos as $campo) {
                if (!Schema::hasColumn('pacientes', $campo)) {
                    $table->text($campo)->nullable();
                }
            }

            if (!Schema::hasColumn('pacientes', 'tipo_sangre')) {
                $table->string('tipo_sangre', 10)->nullable();
            }

            if (!Schema::hasColumn('pacientes', 'contacto_emergencia')) {
                $table->string('contacto_emergencia')->nullable();
            }

            if (!Schema::hasColumn('pacientes', 'telefono_emergencia')) {
                $table->string('telefono_emergencia')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            // intentionally left safe
        });
    }
};
