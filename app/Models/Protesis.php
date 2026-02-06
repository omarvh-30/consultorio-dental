<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protesis extends Model
{
    protected $table = 'protesis';

    protected $fillable = [
        'paciente_id',
        'tipo',
        'zona',
        'fecha_inicio',
        'fecha_termino',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_termino' => 'date',
    ];

    /* ================= RELACIONES ================= */

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function seguimientos()
    {
        return $this->hasMany(ProtesisSeguimiento::class)->orderBy('fecha');
    }

    /* ================= SCOPES ================= */

    public function scopeActiva($query)
    {
        return $query->where('estado', 'en_proceso');
    }
}
