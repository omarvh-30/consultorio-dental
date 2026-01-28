<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('treatment_plans', function (Blueprint $table) {
            $table->longText('firma_paciente')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('treatment_plans', function (Blueprint $table) {
            $table->text('firma_paciente')->nullable()->change();
        });
    }
};
