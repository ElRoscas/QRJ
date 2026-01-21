<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\EsdevenimentController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Rutes Públiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        $hasAdminPerm = $user->permissos()
            ->where('PermCode', '11111')
            ->exists();

        return $hasAdminPerm
            ? redirect()->route('menu_admin')
            : redirect()->route('menu_user');
    }

    return view('welcome');
})->name('home');

// Rutes de Login
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('fortify.login');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('fortify.logout');

// Rutes de Registro
Route::get('/register', [CustomRegisterController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [CustomRegisterController::class, 'store'])
    ->middleware('guest')
    ->name('register.store');

// Vista de Registre antigua (compatibilidad)
Route::get('/registre', function () {
    return redirect()->route('register');
})->name('registre');

// Ruta de preview (sense autenticació) per veure les pàgines durant el desenvolupament
Route::get('/preview/menu-admin', function () {
    return view('menu_admin');
})->name('preview.menu_admin');

Route::get('/preview/evenimente', function () {
    return view('esdeveniments');
})->name('evenimente');

Route::get('/preview/control-usuaris', function () {
    return view('control_usuaris');
})->name('control.usuaris');

Route::get('/preview/info-usuaris', function () {
    return view('info_user');
})->name('info.user', ['user' => 1]);

Route::get('/preview/crear-esdeveniment', function () {
    return view('CrearEsdeveniments');
})->name('preview.crear_esdeveniment');

Route::get('/preview/control-convidats', function () {
    return view('control_convidats');
})->name('control.convidats');

Route::get('/preview/menu-user', function () {
    return view('menu_user');
})->name('preview.menu_user');

Route::get('/preview/graduacio', function () {
    return view('graduacio');
})->name('preview.graduacio');

/*
|--------------------------------------------------------------------------
| Rutes Protegides - Usuaris sense permisos admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Menú per a usuaris sense permisos
    Route::view('menu-user', 'menu_user')->name('menu_user');

    // Llista d'esdeveniments per a usuaris
    Route::get('esdeveniments', [EsdevenimentController::class, 'index'])->name('esdeveniments');
});

/*
|--------------------------------------------------------------------------
| Rutes Protegides - Menú Administrador (amb middleware)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin.perm'])->group(function () {

    // Menú d'Administrador
    Route::view('menu-admin', 'livewire.menu')->name('menu_admin');

    // Llistar els esdeveniments (admin)
    Route::get('admin/esdeveniments', [EsdevenimentController::class, 'index'])->name('esdeveniment.index');

    // Crear esdeveniment
    Route::get('admin/esdeveniments/crear', [EsdevenimentController::class, 'create'])->name('esdeveniment.create');
    Route::post('admin/esdeveniments', [EsdevenimentController::class, 'store'])->name('esdeveniment.store');

    // Editar/eliminar esdeveniment
    Route::get('admin/esdeveniments/{esdeveniment}/editar', [EsdevenimentController::class, 'edit'])->name('esdeveniment.edit');
    Route::put('admin/esdeveniments/{esdeveniment}', [EsdevenimentController::class, 'update'])->name('esdeveniment.update');
    Route::delete('admin/esdeveniments/{esdeveniment}', [EsdevenimentController::class, 'destroy'])->name('esdeveniment.destroy');

    // Volt routes (si las necesitas)
    Volt::route('evenimente', 'llistar-esdeveniments')->name('evenimente.llistar');
    Volt::route('acontecimentos/crear', 'crear-esdeveniment')->name('evenimente.crear');
    Volt::route('događaji/{acontecimento}/editar', 'crear-esdeveniment')->name('události.editar');

    // Control d'accessos (Lector QR)
    Route::view('lector-qr', 'livewire.qr')->name('lector_qr');

    // Dashboard
    Route::view('dashboard', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');

    /* --- Configuració de perfil --- */
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    // GET logout route para testing ràpid
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/')->with('status', 'Has tancat sessió correctament.');
    })->name('logout_get');

});