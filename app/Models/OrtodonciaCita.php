<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrtodonciaCita extends Model
{
    use HasFactory;

    protected $table = 'ortodoncia_citas';

    protected $fillable = [
        'ortodoncia_id',
        'arco_superior',
        'arco_inferior',
    ];

    /* ======================
        RELACIONES
    ====================== */

    // Cita pertenece a un tratamiento de ortodoncia
    public function ortodoncia()
    {
        return $this->belongsTo(Ortodoncia::class);
    }
}
