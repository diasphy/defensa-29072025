<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Por defecto, un nuevo usuario no tendrá rol. Se lo asignaremos después.
            'role_id' => null,
        ]);

        event(new Registered($user));

        // ESTA ES LA LÓGICA QUE CAMBIAMOS:
        // 1. YA NO iniciamos sesión automáticamente al usuario.
        // Auth::login($user); // <-- LÍNEA ELIMINADA

        // 2. Redirigimos al usuario a la página de LOGIN.
        // 3. Le enviamos un mensaje de éxito para que se muestre en la página de login.
        return redirect()->route('login')->with('status', '¡Registro completado! Por favor, inicia sesión.');
    }
}
