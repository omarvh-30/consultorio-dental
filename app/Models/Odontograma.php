<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odontograma extends Model
{
    protected $fillable = [
        'paciente_id',
        'diente',
        'estado',
        'requiere_tratamiento'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}

