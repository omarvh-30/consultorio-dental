<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('limpiezas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('paciente_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('fecha_inicio');

            $table->decimal('costo_total', 10, 2)->default(0);

            $table->text('observaciones')->nullable();

            $table->enum('estado', [
                'activa',
                'finalizada'
            ])->default('activa');

            $table->date('fecha_termino')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('limpiezas');
    }
};