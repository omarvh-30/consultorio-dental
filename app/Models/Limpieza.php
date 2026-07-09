<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Limpieza extends Model
{
    protected $fillable = [
        'paciente_id',
        'fecha_inicio',
        'costo_total',
        'observaciones',
        'estado',
        'fecha_termino',
    ];

    protected $casts = [
        'fecha_inicio'  => 'date',
        'fecha_termino' => 'date',
        'costo_total'   => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function seguimientos()
    {
        return $this->hasMany(LimpiezaSeguimiento::class)
                    ->orderBy('fecha', 'asc');
    }
}