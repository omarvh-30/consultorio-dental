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
    Schema::table('historia_odontologica', function (Blueprint $table) {
        if (!Schema::hasColumn('historia_odontologica', 'observaciones')) {
            $table->text('observaciones')->nullable();
        }
    });
}

public function down()
{
    Schema::table('historia_odontologica', function (Blueprint $table) {
        if (Schema::hasColumn('historia_odontologica', 'observaciones')) {
            $table->dropColumn('observaciones');
        }
    });
}

};
