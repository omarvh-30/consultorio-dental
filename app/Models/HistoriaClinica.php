<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $fillable = [
        'paciente_id',
        'diagnostico_general',
        'plan_tratamiento'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}

