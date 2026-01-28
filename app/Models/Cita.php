<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'paciente_id',
        'fecha_hora',
        'motivo',
        'estado',
        'observaciones'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function evolucion()
    {
        return $this->hasOne(EvolucionClinica::class);
    }
    
    protected $table = 'citas';

    protected $dates = ['fecha_hora'];
    
    protected $casts = [
    'fecha_hora' => 'datetime',
    ];
}

