<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar el formulario de inicio de sesión.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Manejar una solicitud de autenticación entrante.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => trans('auth.failed'),
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirección según el rol del usuario
        switch ($user->rol) {
            case 'administrador':
                return redirect()->intended('/dashboard/admin');
            case 'tecnico':
                return redirect()->intended('/dashboard/tecnico');
            case 'revisor':
                return redirect()->intended('/dashboard/revisor');
            case 'autoridad':
                return redirect()->intended('/dashboard/autoridad');
            case 'auditor':
                return redirect()->intended('/dashboard/auditor');
            case 'desarrollador':
                return redirect()->intended('/dashboard/desarrollador');
            case 'externo':
                return redirect()->intended('/dashboard/externo');
            default:
                return redirect()->intended('/dashboard');
        }
    }

    /**
     * Cerrar sesión de la aplicación.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
