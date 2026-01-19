<?php

use Illuminate\Support\Facades\Route;
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

// CORRECCIÓ: 'livewire.registre' perquè està dins de la carpeta livewire
Route::get('/registre', function () {
    return view('livewire.registre');
})->name('register');

/*
|--------------------------------------------------------------------------
| Rutes Protegides (Només usuaris autenticats)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
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