<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentCatalog extends Model
{
    protected $fillable = [
        'nombre',
        'estado_asociado',
        'precio_referencia',
        'activo'
    ];
}

