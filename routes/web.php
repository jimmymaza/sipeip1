<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\InstitucionController;

use App\Http\Controllers\ObjetivoInstitucionalController;
use App\Http\Controllers\ObjetivoPNDController;
use App\Http\Controllers\ObjetivoODSController;
use App\Http\Controllers\AlineacionObjetivoController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\ProyectoController;

// Ruta raíz: si está autenticado va al dashboard, si no, al login
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Rutas para invitados (no autenticados)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Recuperación de contraseña con prefijo /password
    Route::prefix('password')->name('password.')->group(function () {
        // Ruta GET para forgot que muestra solo un mensaje simple
        Route::get('/forgot', function () {
            return view('auth.passwords.simple-recovery-message'); // Aquí va tu vista con el mensaje y botón
        })->name('request');

        // Ruta POST para envío real del email de recuperación (opcional)
        Route::post('/forgot', [PasswordResetLinkController::class, 'store'])->name('email');

        // Rutas para reset con token
        Route::get('/reset/{token}', [NewPasswordController::class, 'create'])->name('reset');
        Route::post('/reset', [NewPasswordController::class, 'store'])->name('update');
    });
});

// Rutas para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'roles' => RolController::class,
        'usuarios' => UsuarioController::class,
        'instituciones' => InstitucionController::class,
        'objetivo-institucional' => ObjetivoInstitucionalController::class,
        'objetivo-pnd' => ObjetivoPNDController::class,
        'objetivo-ods' => ObjetivoODSController::class,
        'alineacion' => AlineacionObjetivoController::class,
        'metas' => MetaController::class,
        'proyectos' => ProyectoController::class,
    ]);
});
