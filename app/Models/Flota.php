<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flota extends Model
{
    use HasFactory;

    protected $table = 'flotas';
    protected $primaryKey = 'id_flota';

    protected $fillable = [
        'placa',
        'marca',
        'tipo',
        'estado'
    ];

    public function viajes()
    {
        return $this->hasMany(Viajes::class, 'cod_flota', 'id_flota');
    }
}