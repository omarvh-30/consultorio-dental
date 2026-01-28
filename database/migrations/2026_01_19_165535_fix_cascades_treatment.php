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
    Schema::table('treatment_plan_items', function (Blueprint $table) {
        $table->dropForeign(['treatment_plan_id']);

        $table->foreign('treatment_plan_id')
            ->references('id')
            ->on('treatment_plans')
            ->onDelete('cascade');
    });

    Schema::table('treatment_plans', function (Blueprint $table) {
        $table->dropForeign(['paciente_id']);

        $table->foreign('paciente_id')
            ->references('id')
            ->on('pacientes')
            ->onDelete('cascade');
    });
}

public function down()
{
    // opcional revertir
}

};
