<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('ortodoncias', function (Blueprint $table) {

            $table->id();

            // Relación con paciente
            $table->foreignId('paciente_id')
                  ->constrained('pacientes')
                  ->cascadeOnDelete();

            // Configuración inicial (una sola vez)
            $table->string('tipo_brackets'); // Metálicos, Estéticos, etc.
            $table->date('fecha_inicio');

            // Estado general del tratamiento
            $table->enum('estado', [
                'activo',
                'pausado',
                'finalizado'
            ])->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ortodoncias');
    }

};
