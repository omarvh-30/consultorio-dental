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
        Schema::create('treatment_plan_items', function (Blueprint $table) {

        $table->id();
        $table->foreignId('treatment_plan_id')->constrained();

        $table->string('diente');

        $table->string('tratamiento');
        $table->decimal('precio_catalogo', 10, 2);
        $table->decimal('precio_paciente', 10, 2);

        $table->enum('estatus', [
        'pendiente',
        'terminado'
        ])->default('pendiente');

        $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_plan_items');
    }
};
