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
    Schema::create('protesis', function (Blueprint $table) {
        $table->id();

        $table->foreignId('paciente_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->enum('tipo', [
            'superior',
            'inferior',
            'completa',
            'parcial'
        ]);

        $table->enum('zona', [
            'maxilar',
            'mandibula',
            'bimaxilar'
        ])->nullable();

        $table->date('fecha_inicio');

        $table->date('fecha_termino')->nullable();

        $table->enum('estado', [
            'en_proceso',
            'finalizada',
            'reemplazada'
        ])->default('en_proceso');

        $table->text('observaciones')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proteses');
    }
};
