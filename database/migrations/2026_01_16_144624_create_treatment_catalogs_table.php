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
        Schema::create('treatment_catalogs', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');

            // A qué estado del odontograma responde
            $table->enum('estado_asociado', [
                'caries',
                'endodoncia',
                'obturado'
            ]);

            $table->decimal('precio_referencia', 10, 2);

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_catalogs');
    }
};
