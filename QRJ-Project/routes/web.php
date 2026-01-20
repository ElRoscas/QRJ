<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomRegisterController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Rutes Públiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Si l'usuari ja està loguejat, el portem directament al Menú Admin
    if (auth()->check()) {
        return redirect()->route('menu_admin');
    }
    // CORRECCIÓ: 'welcome' en lloc de 'welcome.blade.php'
    return view('welcome');
})->name('home');

// Rutes de Login
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('fortify.login');

// Logout via GET (per testing - accés ràpid)
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('quick.logout');

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
    return view('evenimente');
})->name('evenimente');

Route::get('/preview/control-usuaris', function () {
    return view('control_usuaris');
})->name('control.usuaris');

Route::get('/preview/info-usuaris', function () {
    return view('info_user');
})->name('info.user', ['user' => 1]);

Route::get('/preview/crear-evenimente', function () {
    return view('CrearEsdeveniments');
})->name('event.create');

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
| Rutes Protegides (Només usuaris autenticats)
|--------------------------------------------------------------------------
*/

// Ruta para usuarios sin permisos de admin (temporal - preparada para otra vista)
Route::middleware(['auth'])->group(function () {
    Route::view('menu-user', 'livewire.menu-user')->name('menu_user');
});

Route::middleware(['auth', 'admin.perm'])->group(function () {

    // Menú d'Administrador
    Route::view('menu-admin', 'livewire.menu')->name('menu_admin');

    // Llistar els esdeveniments
    Volt::route('esdeveniments', 'llistar-esdeveniments')->name('esdeveniments.llistar');

    // Crear o editar esdeveniments
    Volt::route('esdeveniments/crear', 'crear-esdeveniment')->name('esdeveniments.crear');
    Volt::route('esdeveniments/{esdeveniment}/editar', 'crear-esdeveniment')->name('esdeveniments.editar');

    // Control d'accessos (Lector QR)
    Route::view('lector-qr', 'livewire.qr')->name('lector_qr');

    Route::view('dashboard', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');

    /* --- Configuració de perfil --- */
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
});