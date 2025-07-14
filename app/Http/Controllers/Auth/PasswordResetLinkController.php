<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.email'); // la vista que ya hiciste
    }

    public function store(Request $request)
    {
        $request->validate([
            'Correo' => 'required|email',
        ]);

        // Cambiar el campo "email" por "Correo" en las credenciales
        $status = Password::sendResetLink(
            $request->only('Correo')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['Correo' => __($status)]);
    }
}


