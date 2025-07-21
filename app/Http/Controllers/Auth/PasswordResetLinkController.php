<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password'); // Vista para solicitar email
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Validar que el correo exista en la tabla usuarios, campo Correo
        $user = User::where('Correo', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => trans('passwords.user')]);
        }

        // Usar broker 'usuarios' y enviar el link con el campo 'Correo'
        $status = Password::broker('usuarios')->sendResetLink(
            ['Correo' => $request->email]
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
}
