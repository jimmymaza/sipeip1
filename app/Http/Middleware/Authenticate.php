<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Obtener la ruta a la que el usuario debe ser redirigido cuando no está autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Si el usuario no está autenticado y no es una petición ajax, redirigir a login
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
