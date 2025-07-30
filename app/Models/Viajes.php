<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viajes extends Model
{
    use HasFactory;

    protected $table = 'viajes';
    protected $primaryKey = 'id_viaje';

    protected $fillable = [
        'fecha',
        'hora',
        'cod_flota',
        'cod_origen',
        'cod_destino',
        'estado',
    ];

   
    public function flota()
    {
        return $this->belongsTo(Flota::class, 'cod_flota', 'id_flota');
    }

    
    public function origen()
    {
        return $this->belongsTo(Ciudades::class, 'cod_origen', 'id_ciudad');
    }

   
    public function destino()
    {
        return $this->belongsTo(Ciudades::class, 'cod_destino', 'id_ciudad');
    }
}