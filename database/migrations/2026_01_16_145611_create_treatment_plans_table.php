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
        Schema::create('treatment_plans', function (Blueprint $table) {

        $table->id();
        $table->foreignId('paciente_id')->constrained();

        $table->decimal('total', 10, 2)->default(0);
        $table->decimal('pagado', 10, 2)->default(0);
        $table->decimal('saldo', 10, 2)->default(0);

        $table->enum('estatus', [
        'borrador',
        'aceptado',
        'en_proceso',
        'finalizado'
        ])->default('borrador');

        $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_plans');
    }
};
