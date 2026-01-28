<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentPayment extends Model
{
    protected $fillable = [
        'treatment_plan_id',
        'monto',
        'metodo',
        'nota'
    ];

    public function plan()
    {
        return $this->belongsTo(TreatmentPlan::class, 'treatment_plan_id');
    }
}
