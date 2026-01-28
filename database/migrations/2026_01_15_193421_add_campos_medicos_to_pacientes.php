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
        Schema::table('pacientes', function (Blueprint $table) {

            $table->text('antecedentes_heredofamiliares')->nullable();
            $table->text('antecedentes_patologicos')->nullable();
            $table->text('antecedentes_no_patologicos')->nullable();

            $table->text('tratamiento_medico')->nullable();

            $table->text('enfermedades')->nullable();
            $table->text('traumatismos')->nullable();
            $table->text('transfusiones_cirugias')->nullable();

            $table->string('tipo_sangre', 10)->nullable();

            $table->string('contacto_emergencia')->nullable();
            $table->string('telefono_emergencia')->nullable();

            $table->text('motivo_consulta')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            //
        });
    }
};
