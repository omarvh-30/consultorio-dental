<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirmaEvolucion extends Model
{
    protected $table = 'firmas_evolucion';

    protected $fillable = [
        'evolucion_id',
        'firma_base64'
    ];

    public function evolucion()
    {
        return $this->belongsTo(EvolucionClinica::class, 'evolucion_id');
    }
}
