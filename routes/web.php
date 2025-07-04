<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;

// Página principal (acceso público)
Route::get('/', function () {
    return view('welcome');
});

// Rutas para invitados (guest)
Route::middleware('guest')->group(function () {
    // Registro
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Ruta para cerrar sesión (solo usuarios autenticados)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Grupo de rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // Dashboard general (opcional)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Dashboards específicos según rol
    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin');
    })->name('dashboard.admin');

    Route::get('/dashboard/tecnico', function () {
        return view('dashboard.tecnico');
    })->name('dashboard.tecnico');

    Route::get('/dashboard/revisor', function () {
        return view('dashboard.revisor');
    })->name('dashboard.revisor');

    Route::get('/dashboard/autoridad', function () {
        return view('dashboard.autoridad');
    })->name('dashboard.autoridad');

    Route::get('/dashboard/auditor', function () {
        return view('dashboard.auditor');
    })->name('dashboard.auditor');

    Route::get('/dashboard/desarrollador', function () {
        return view('dashboard.desarrollador');
    })->name('dashboard.desarrollador');

    Route::get('/dashboard/externo', function () {
        return view('dashboard.externo');
    })->name('dashboard.externo');

    // CRUD Usuarios
    Route::resource('usuarios', UserController::class)->middleware('auth');
    // CRUD Roles
    Route::resource('roles', RolController::class);
    
});
