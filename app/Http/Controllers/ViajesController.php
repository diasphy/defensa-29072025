<?php

namespace App\Http\Controllers;

use App\Models\Flota;
use App\Models\Ciudades;
use App\Models\Viajes;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ViajesController extends Controller
{
   public function index()
{
   
    $flotas = Flota::all();  
    $ciudades = Ciudades::all();  
    $viajes = Viajes::orderBy('fecha', 'desc')->get();
    
    return Inertia::render('Viaje/Index', [
        'viajes' => $viajes,
        'flotas' => $flotas,
        'ciudades' => $ciudades
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required',
            'cod_flota' => 'required|exists:flotas,id_flota',
            'cod_origen' => 'required|exists:ciudades,id_ciudad',
            'cod_destino' => 'required|exists:ciudades,id_ciudad',
        ]);

      
Viajes::create([
    'fecha' => $request->fecha,
    'hora' => $request->hora,
    'cod_flota' => $request->cod_flota,
    'cod_origen' => $request->cod_origen,
    'cod_destino' => $request->cod_destino,
    'estado' => 1, 
]);

        return redirect()->back()->with('message', 'Viaje registrado exitosamente');
    }
}