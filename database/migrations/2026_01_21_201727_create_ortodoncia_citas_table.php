<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('ortodoncia_citas', function (Blueprint $table) {

            $table->id();

            // Relación con ortodoncia
            $table->foreignId('ortodoncia_id')
                  ->constrained('ortodoncias')
                  ->cascadeOnDelete();

            // Datos por cita
            $table->string('arco_superior')->nullable();
            $table->string('arco_inferior')->nullable();

            // Fecha automática
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ortodoncia_citas');
    }

};
