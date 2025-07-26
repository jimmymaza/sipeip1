<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar entrada
        $credentials = $request->validate([
            'cedula' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Buscar usuario por Cédula o Correo
        $user = User::where('Cedula', $credentials['cedula'])
                    ->orWhere('Correo', $credentials['cedula'])
                    ->first();

        // Verificar existencia de usuario
        if (!$user) {
            return back()->withErrors([
                'cedula' => 'Usuario no encontrado.',
            ])->withInput();
        }

        // Verificar la contraseña
        if (!Hash::check($credentials['password'], $user->Clave)) {
            return back()->withErrors([
                'password' => 'Contraseña incorrecta.',
            ])->withInput();
        }

        // Iniciar sesión si todo es correcto
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
