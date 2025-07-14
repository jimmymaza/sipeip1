<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'usuarios'), // Broker personalizado
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'usuarios',  // Usa el provider 'usuarios' definido abajo
        ],
    ],

    'providers' => [
        'usuarios' => [
            'driver' => 'eloquent',
            // Tu modelo User personalizado
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
    ],

    'passwords' => [
        'usuarios' => [
            'provider' => 'usuarios',
            // Tabla para tokens de recuperación. Debes tener esta tabla en la DB.
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_resets'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
