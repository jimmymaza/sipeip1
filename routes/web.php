<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\ObjetivoInstitucionalController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\AlineacionObjetivoController;
use App\Http\Controllers\ReporteController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (sin autenticación)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('root');

// Login y recuperación de contraseña
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::prefix('password')->name('password.')->group(function () {
        Route::get('/forgot', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('request');
        Route::post('/forgot', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('email');
        Route::get('/reset/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('reset');
        Route::post('/reset', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('update');
    });
});

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (requieren autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Redirecciones para evitar error por falta de parámetro {tipo}
    Route::redirect('/objetivos', '/objetivos/institucional')->name('objetivos.default');
    Route::redirect('/objetivos/create', '/objetivos/institucional/create')->name('objetivos.create.default');

    // Usuarios y Roles
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);

    // Instituciones
    Route::resource('instituciones', InstitucionController::class);

    // Objetivos por tipo con prefijo y nombre
    Route::prefix('objetivos/{tipo}')->name('objetivos.')->group(function () {
        Route::get('/', [ObjetivoInstitucionalController::class, 'index'])->name('index');
        Route::get('/create', [ObjetivoInstitucionalController::class, 'create'])->name('create');
        Route::post('/', [ObjetivoInstitucionalController::class, 'store'])->name('store');
        Route::get('/{objetivo}/edit', [ObjetivoInstitucionalController::class, 'edit'])->name('edit');
        Route::put('/{objetivo}', [ObjetivoInstitucionalController::class, 'update'])->name('update');
        Route::delete('/{objetivo}', [ObjetivoInstitucionalController::class, 'destroy'])->name('destroy');
        Route::get('/{objetivo}', [ObjetivoInstitucionalController::class, 'show'])->name('show');

        // Alineaciones anidadas por objetivo
        Route::prefix('{objetivo}/alineaciones')->name('alineaciones.')->group(function () {
            Route::get('/', [AlineacionObjetivoController::class, 'index'])->name('index');
            Route::get('/create', [AlineacionObjetivoController::class, 'create'])->name('create');
            Route::post('/', [AlineacionObjetivoController::class, 'store'])->name('store');
            Route::get('/{alineacion}/edit', [AlineacionObjetivoController::class, 'edit'])->name('edit');
            Route::put('/{alineacion}', [AlineacionObjetivoController::class, 'update'])->name('update');
            Route::delete('/{alineacion}', [AlineacionObjetivoController::class, 'destroy'])->name('destroy');
        });
    });

    // Metas
    Route::resource('metas', MetaController::class);

    // Planes
    Route::resource('planes', PlanController::class)->parameters([
        'planes' => 'plan',
    ]);

    // Programas
    Route::resource('programas', ProgramaController::class);

    // Proyectos
    Route::resource('proyectos', ProyectoController::class);

    /*
    |--------------------------------------------------------------------------
    | Reportes
    |--------------------------------------------------------------------------
    */
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');

        // Ruta para generar reportes y también exportar PDF, según parámetro 'action'
        Route::match(['get', 'post'], '/generar', [ReporteController::class, 'generar'])->name('generar');

        // Si no tienes un método separado para exportar PDF, no incluyas esta ruta
        // Route::post('/exportar/pdf', [ReporteController::class, 'exportarPDF'])->name('exportar.pdf');
    });

});
