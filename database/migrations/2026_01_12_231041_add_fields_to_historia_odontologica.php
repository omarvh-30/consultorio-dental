<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('historia_odontologica', function (Blueprint $table) {

            if (!Schema::hasColumn('historia_odontologica', 'diente')) {
                $table->string('diente')->after('paciente_id');
            }

            if (!Schema::hasColumn('historia_odontologica', 'estado')) {
                $table->string('estado')->after('diente');
            }

            if (!Schema::hasColumn('historia_odontologica', 'observaciones')) {
                $table->text('observaciones')->nullable()->after('estado');
            }

            if (!Schema::hasColumn('historia_odontologica', 'fecha')) {
                $table->timestamp('fecha')->nullable()->after('observaciones');
            }
        });
    }

    public function down()
    {
        Schema::table('historia_odontologica', function (Blueprint $table) {

            if (Schema::hasColumn('historia_odontologica', 'diente')) {
                $table->dropColumn('diente');
            }

            if (Schema::hasColumn('historia_odontologica', 'estado')) {
                $table->dropColumn('estado');
            }

            if (Schema::hasColumn('historia_odontologica', 'observaciones')) {
                $table->dropColumn('observaciones');
            }

            if (Schema::hasColumn('historia_odontologica', 'fecha')) {
                $table->dropColumn('fecha');
            }
        });
    }
};
