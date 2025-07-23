<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ObjetivoInstitucionalController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\AlineacionObjetivoController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\VinculacionController;
use App\Http\Controllers\CronogramaController;
use App\Http\Controllers\PresupuestoController;

// Controladores para recuperación de contraseña
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

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
        Route::get('/forgot', [PasswordResetLinkController::class, 'create'])->name('request');
        Route::post('/forgot', [PasswordResetLinkController::class, 'store'])->name('email');
        Route::get('/reset/{token}', [NewPasswordController::class, 'create'])->name('reset');
        Route::post('/reset', [NewPasswordController::class, 'store'])->name('update');
    });
});

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (requieren autenticación y acceso a módulos)
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
    Route::middleware('checkmodulo:Roles')->group(function () {
        Route::resource('roles', RolController::class);
    });

    Route::middleware('checkmodulo:Usuarios')->group(function () {
        Route::resource('usuarios', UsuarioController::class);
    });

    // Instituciones
    Route::middleware('checkmodulo:Instituciones')->group(function () {
        Route::resource('instituciones', InstitucionController::class);
    });

    // Objetivos por tipo con prefijo y nombre
    Route::middleware('checkmodulo:Objetivos')->prefix('objetivos/{tipo}')->name('objetivos.')->group(function () {
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

    // Indicadores
    Route::middleware('checkmodulo:Indicadores')->group(function () {
        Route::resource('indicadores', IndicadorController::class);
    });

    // Vinculaciones
    Route::middleware('checkmodulo:Vinculaciones')->group(function () {
        Route::resource('vinculaciones', VinculacionController::class)->parameters([
            'vinculaciones' => 'vinculacion',
        ]);
    });

    // Metas
    Route::middleware('checkmodulo:Metas')->group(function () {
        Route::resource('metas', MetaController::class);
    });

    // Planes
    Route::middleware('checkmodulo:Planes')->group(function () {
        Route::resource('planes', PlanController::class)->parameters([
            'planes' => 'plan',
        ]);
    });

    // Cronogramas
    Route::middleware('checkmodulo:Cronogramas')->group(function () {
        Route::resource('cronogramas', CronogramaController::class);
    });

    // Presupuestos
    Route::middleware('checkmodulo:Presupuestos')->group(function () {
        Route::resource('presupuestos', PresupuestoController::class);
    });

    // Programas
    Route::middleware('checkmodulo:Programas')->group(function () {
        Route::resource('programas', ProgramaController::class);
    });

    // Proyectos
    Route::middleware('checkmodulo:Proyectos')->group(function () {
        Route::resource('proyectos', ProyectoController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Reportes
    |--------------------------------------------------------------------------
    */
    Route::middleware('checkmodulo:Reportes')->prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/generar', [ReporteController::class, 'generar'])->name('generar');
    });

    // Ruta para probar módulos del usuario autenticado
    Route::get('/probar-modulos', function () {
        $usuario = Auth::user();

        if (!$usuario) {
            return 'Usuario no autenticado';
        }

        return response()->json([
            'Usuario' => $usuario->Nombre . ' ' . $usuario->Apellido,
            'Correo' => $usuario->Correo,
            'ModulosCompletos' => $usuario->modulosCompletos(),
        ]);
    });
});
