<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentPlanItem extends Model
{
    protected $fillable = [
    'treatment_plan_id',
    'diente',
    'tratamiento',
    'precio_catalogo',
    'precio_paciente'
    ];
 
    public function plan()
    {
        return $this->belongsTo(TreatmentPlan::class, 'treatment_plan_id');
    }


}
