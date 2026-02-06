<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProtesisSeguimiento extends Model
{
    protected $fillable = [
        'protesis_id',
        'fecha',
        'tipo_evento',
        'descripcion'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function protesis()
    {
        return $this->belongsTo(Protesis::class);
    }
}
