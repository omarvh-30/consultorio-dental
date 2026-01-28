<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ortodoncia extends Model
{
    use HasFactory;

    protected $table = 'ortodoncias';

protected $fillable = [
    'paciente_id',
    'tipo_brackets',
    'fecha_inicio',
    'estado',

    // NUEVOS CAMPOS
    'diagnostico',
    'fecha_profilaxis',
    'fecha_colocacion',
    'fecha_retiro',
    'fecha_retenedores',
    'fecha_fin',
];

protected $casts = [
    'fecha_inicio'        => 'date',
    'fecha_profilaxis'    => 'date',
    'fecha_colocacion'    => 'date',
    'fecha_retiro'        => 'date',
    'fecha_retenedores'   => 'date',
    'fecha_fin'           => 'date',
];


    /* ======================
        RELACIONES
    ====================== */

    // Ortodoncia pertenece a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Ortodoncia tiene muchas citas
    public function citas()
    {
        return $this->hasMany(OrtodonciaCita::class);
    }
    public function pasosCompletosParaSeguimiento()
    {
        return $this->diagnostico
            && $this->fecha_profilaxis
            && $this->fecha_colocacion;
    }

    public function seguimientoActivo()
    {
        return $this->estado_seguimiento === 'activo';
    }


}
