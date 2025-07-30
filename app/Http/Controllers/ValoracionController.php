<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia; 
class ValoracionController extends Controller
{
    //
    public function index()
    {
        
        return Inertia::render('Valoracion/Index', [
          
        ]);
    }
}
