<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evolucion_clinicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')
                ->constrained('citas')
                ->onDelete('cascade');

            $table->text('diagnostico');
            $table->text('procedimiento');
            $table->text('indicaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evolucion_clinicas');
    }
};
