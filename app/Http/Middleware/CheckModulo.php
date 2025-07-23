<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckModulo
{
    /**
     * Maneja la solicitud entrante y verifica que el usuario tenga acceso al módulo indicado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $modulo  Nombre del módulo requerido
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $modulo)
    {
        $user = Auth::user();

        // Verificar si está autenticado
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para continuar.');
        }

        // Verificar que el método modulosCompletos exista en el modelo User
        if (!method_exists($user, 'modulosCompletos')) {
            abort(500, 'Error interno: método modulosCompletos no definido en User.');
        }

        // Obtener los módulos permitidos para el usuario
        $modulosPermitidos = $user->modulosCompletos();

        // Validar que sea un array
        if (!is_array($modulosPermitidos)) {
            abort(500, 'Error interno: modulosCompletos debe retornar un array.');
        }

        // Verificar si el módulo solicitado está en la lista de módulos permitidos
        if (!in_array($modulo, $modulosPermitidos)) {
            // Puedes usar redirect()->back() si quieres volver a la página anterior
            return redirect()->back()->with('error', 'No tiene permiso para acceder al módulo: ' . $modulo);
        }

        // Pasar la solicitud al siguiente middleware o controlador
        return $next($request);
    }
}
