<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ValoracionController; 
use App\Http\Controllers\ViajesController; 
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Redirigir la raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // vista
    Route::get('/valoracion', [ValoracionController::class, 'index'])->name('valoracion.index');
    Route::get('/viajes', [ViajesController::class, 'index'])->name('viajes.index');

    // Route::get('/viajes', [ViajesController::class, 'index'])->name('viajes.index');
    Route::post('/viajes', [ViajesController::class, 'store'])->name('viajes.store');




});

require __DIR__.'/auth.php';