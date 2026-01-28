<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequiereTratamientoToOdontogramas extends Migration
{
    public function up()
    {
        Schema::table('odontogramas', function (Blueprint $table) {
            if (!Schema::hasColumn('odontogramas', 'requiere_tratamiento')) {
                $table->boolean('requiere_tratamiento')
                    ->default(false)
                    ->after('estado');
            }
        });
    }

    public function down()
    {
        Schema::table('odontogramas', function (Blueprint $table) {
            if (Schema::hasColumn('odontogramas', 'requiere_tratamiento')) {
                $table->dropColumn('requiere_tratamiento');
            }
        });
    }
}
