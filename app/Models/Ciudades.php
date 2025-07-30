<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{
    use HasFactory;

    protected $table = 'ciudades';
    protected $primaryKey = 'id_ciudad';

    protected $fillable = [
        'nombre',
        'altura',
        'estado'
    ];

   
    public function viajesOrigen()
    {
        return $this->hasMany(Viajes::class, 'cod_origen', 'id_ciudad');
    }

    
    public function viajesDestino()
    {
        return $this->hasMany(Viajes::class, 'cod_destino', 'id_ciudad');
    }
}