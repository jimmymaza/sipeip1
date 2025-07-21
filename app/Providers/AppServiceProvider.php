<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\EloquentUserProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar un UserProvider personalizado que usa 'Correo' en lugar de 'email'
        Auth::provider('custom', function ($app, array $config) {
            return new class($app['hash'], $config['model']) extends EloquentUserProvider {
                public function retrieveByCredentials(array $credentials)
                {
                    // Si viene el campo 'email' en las credenciales, ignorarlo
                    $credentials = collect($credentials)->reject(function ($value, $key) {
                        return $key === 'email';
                    })->toArray();

                    // Buscar por 'Correo' en lugar de 'email'
                    if (isset($credentials['Correo'])) {
                        return $this->createModel()->newQuery()
                            ->where('Correo', $credentials['Correo'])
                            ->first();
                    }

                    return parent::retrieveByCredentials($credentials);
                }
            };
        });
    }
}
