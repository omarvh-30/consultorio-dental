<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LimpiezaSeguimiento extends Model
{
    protected $fillable = [
        'limpieza_id',
        'catalogo_limpieza_id',
        'fecha',
        'observaciones',
        'pago',
        'proxima_cita',
        'firma',
    ];

    protected $casts = [
        'fecha'         => 'date',
        'proxima_cita'  => 'date',
        'pago'          => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function limpieza()
    {
        return $this->belongsTo(Limpieza::class);
    }

    public function catalogo()
    {
        return $this->belongsTo(CatalogoLimpieza::class, 'catalogo_limpieza_id');
    }
}