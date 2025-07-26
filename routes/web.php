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

Route::middleware(['auth'])->group(function () {

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

    Route::bind('objetivo', function ($value, $route) {
        $tipoUrl = strtolower(trim($route->parameter('tipo') ?? ''));

        $tipoMapeado = [
            'institucional'   => 'institucional',
            'plan_nacional'   => 'nacional',
            'ods'             => 'ods',
        ];

        if (!array_key_exists($tipoUrl, $tipoMapeado)) {
            abort(404, 'Tipo inválido.');
        }

        $tipoBD = $tipoMapeado[$tipoUrl];

        return \App\Models\ObjetivoInstitucional::where('id', $value)
            ->where('tipo', $tipoBD)
            ->firstOrFail();
    });

    // Objetivos por tipo con prefijo y nombre
    Route::prefix('objetivos/{tipo}')
        ->where(['tipo' => 'institucional|plan_nacional|ods'])  // <-- CORREGIDO: donde 'where' recibe array asociativo
        ->name('objetivos.')
        ->group(function () {
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
    Route::resource('indicadores', IndicadorController::class)->parameters([
        'indicadores' => 'indicador',
    ]);

    // Vinculaciones
    Route::resource('vinculaciones', VinculacionController::class)->parameters([
        'vinculaciones' => 'vinculacion',
    ]);

    // Metas
    Route::resource('metas', MetaController::class);

    // Planes
    Route::resource('planes', PlanController::class)->parameters([
        'planes' => 'plan',
    ]);

    // Cronogramas
    Route::resource('cronogramas', CronogramaController::class);

    // Presupuestos
    Route::resource('presupuestos', PresupuestoController::class);

    // Programas
    Route::resource('programas', ProgramaController::class);

    // Proyectos
    Route::resource('proyectos', ProyectoController::class);

   
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/generar', [ReporteController::class, 'generar'])->name('generar');
    });


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
