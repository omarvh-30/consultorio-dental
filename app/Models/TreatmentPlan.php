<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TreatmentPlanItem;
use App\Models\TreatmentPayment;

class TreatmentPlan extends Model
{
    protected $fillable = [
        'paciente_id',
        'total',
        'pagado',
        'saldo',
        'estatus',
        'aceptado',
        'firma_paciente',
        'fecha_aceptacion'
    ];

    protected $casts = [
        'fecha_aceptacion' => 'datetime',
        'aceptado'         => 'boolean',
        'total'            => 'decimal:2',
        'pagado'           => 'decimal:2',
        'saldo'            => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(TreatmentPlanItem::class);
    }

    public function pagos()
    {
        return $this->hasMany(TreatmentPayment::class);
    }

    public function scopeActivo($query)
    {
        return $query->where('estatus', '!=', 'finalizado');
    }

}
