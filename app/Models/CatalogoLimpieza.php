<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoLimpieza extends Model
{
    protected $table = 'catalogo_limpiezas';

    protected $fillable = [
        'nombre',
        'precio',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function seguimientos()
    {
        return $this->hasMany(LimpiezaSeguimiento::class, 'catalogo_limpieza_id');
    }
}