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
        Schema::create('firmas_evolucion', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('evolucion_id');

            $table->longText('firma_base64');

            $table->timestamps();

            $table->foreign('evolucion_id')
                ->references('id')
                ->on('evolucion_clinicas')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firmas_evolucion');
    }
};
