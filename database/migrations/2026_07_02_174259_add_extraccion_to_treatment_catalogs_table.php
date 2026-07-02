<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar soporte a "extraccion" al ENUM
        DB::statement("
            ALTER TABLE treatment_catalogs 
            MODIFY estado_asociado ENUM('caries','endodoncia','obturado','extraccion')
        ");
    }

    public function down(): void
    {
        // Regresar al estado anterior
        DB::statement("
            ALTER TABLE treatment_catalogs 
            MODIFY estado_asociado ENUM('caries','endodoncia','obturado')
        ");
    }

    
};