<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Middleware globales que se ejecutan en todas las solicitudes HTTP.
     *
     * Estos middleware se aplican a todas las rutas y peticiones de la aplicación.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // Gestiona proxies confiables
        \App\Http\Middleware\TrustProxies::class,

        // Maneja CORS (Cross-Origin Resource Sharing)
        \Illuminate\Http\Middleware\HandleCors::class,

        // Previene peticiones cuando la aplicación está en mantenimiento
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // Valida el tamaño máximo de la petición POST
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Limpia espacios en blanco al inicio y final de los inputs
        \App\Http\Middleware\TrimStrings::class,

        // Convierte cadenas vacías en null para facilitar validaciones
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Grupos de middleware para rutas web y API.
     *
     * Estos middleware se asignan automáticamente a rutas con el grupo correspondiente.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            // Encripta cookies para mayor seguridad
            \App\Http\Middleware\EncryptCookies::class,

            // Añade cookies a la respuesta
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            // Inicia la sesión HTTP
            \Illuminate\Session\Middleware\StartSession::class,

            // Comparte errores de sesión con las vistas
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // Protección CSRF contra ataques de tipo Cross-site request forgery
            \App\Http\Middleware\VerifyCsrfToken::class,

            // Reemplaza parámetros de ruta con modelos u otros valores
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // Limita la cantidad de peticiones a la API
            'throttle:api',

            // Sustituye bindings de rutas
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Middleware que pueden ser asignados a rutas individuales o grupos.
     *
     * Se pueden invocar directamente con su nombre en la definición de rutas.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        // Autenticación básica y avanzada
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        // Redirecciona usuarios autenticados
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // Confirmación de contraseña para acciones sensibles
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        // Verifica email confirmado
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Autorización basada en políticas
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // Validación de firmas URL
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // Limitación de tasa de peticiones
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Control de cache mediante headers HTTP
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        // No hay middleware personalizado 'checkrole'
    ];
}
