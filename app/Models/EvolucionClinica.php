<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvolucionClinica extends Model
{
    protected $fillable = [
        'cita_id',
        'diagnostico',
        'procedimiento',
        'indicaciones'
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
    public function firma()
    {
        return $this->hasOne(FirmaEvolucion::class, 'evolucion_id');
    }

}

