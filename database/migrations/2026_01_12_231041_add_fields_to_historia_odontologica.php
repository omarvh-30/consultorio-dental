<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('historia_odontologica', function (Blueprint $table) {
            $table->string('diente')->after('paciente_id');
            $table->string('estado')->after('diente');
            $table->text('observaciones')->nullable()->after('estado');
            $table->timestamp('fecha')->nullable()->after('observaciones');
        });
    }

    public function down()
    {
        Schema::table('historia_odontologica', function (Blueprint $table) {
            $table->dropColumn(['diente', 'estado', 'observaciones', 'fecha']);
        });
    }
};
