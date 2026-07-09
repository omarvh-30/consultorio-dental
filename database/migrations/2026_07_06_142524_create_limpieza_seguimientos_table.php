<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('limpieza_seguimientos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('limpieza_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('catalogo_limpieza_id')
                ->constrained('catalogo_limpiezas');

            $table->date('fecha');

            $table->text('observaciones')->nullable();

            $table->decimal('pago', 10, 2)->default(0);

            $table->date('proxima_cita')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('limpieza_seguimientos');
    }
};