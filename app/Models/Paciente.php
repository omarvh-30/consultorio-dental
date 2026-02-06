<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Odontograma;

class Paciente extends Model
{
    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'fecha_nacimiento',
        'sexo',
        'alergias',

        'antecedentes_heredofamiliares',
        'antecedentes_patologicos',
        'antecedentes_no_patologicos',

        'tratamiento_medico',

        'enfermedades',
        'traumatismos',
        'transfusiones_cirugias',

        'tipo_sangre',

        'contacto_emergencia',
        'telefono_emergencia',

        'motivo_consulta',

        'es_ortodoncia',
        'es_protesis',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function historiaClinica()
    {
        return $this->hasOne(HistoriaClinica::class);
    }
    public function odontograma()
    {
        return $this->hasMany(Odontograma::class);
    }
    protected $casts = [
    'es_ortodoncia' => 'boolean', 'es_protesis' => 'boolean',
    ];

    public function ortodoncia()
    {
        return $this->hasOne(Ortodoncia::class);
    }
    public function protesis()
    {
        return $this->hasMany(Protesis::class);
    }

    public function protesisActiva()
    {
        return $this->hasOne(Protesis::class)
                    ->where('estado', 'en_proceso');
    }

}
