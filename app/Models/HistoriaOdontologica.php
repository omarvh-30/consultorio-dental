<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaOdontologica extends Model
{
    use HasFactory;

    protected $table = 'historia_odontologica';

    protected $fillable = [
        'paciente_id',
        'diente',
        'estado',
        'observaciones',
        'fecha'
    ];
    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
