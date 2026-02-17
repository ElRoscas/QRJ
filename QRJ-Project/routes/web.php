<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EsdevenimentController;
use App\Http\Controllers\QrCodeController;
use Livewire\Volt\Volt;
use Illuminate\Http\Request;

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
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('fortify.login');

Route::get('/login', function () {
    return redirect()->route('home');
})
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [LoginController::class, 'destroy'])
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
})->name('info.user');

Route::get('/preview/crear-esdeveniment', function () {
    return view('CrearEsdeveniments');
})->name('preview.crear_esdeveniment');

Route::get('/preview/control-convidats', function () {
    return view('control_convidats', ['guests' => []]);
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

    // Alias per llistar esdeveniments (usuaris i admin)
    Route::get('esdeveniments/llistar', [EsdevenimentController::class, 'index'])->name('esdeveniments.llistar');

    // User event registration routes
    Route::get('events', [EsdevenimentController::class, 'userList'])->name('events.user-list');
    Route::get('events/{event}/register', [EsdevenimentController::class, 'userRegisterForm'])->name('events.user-register');
    Route::post('events/{event}/register', [EsdevenimentController::class, 'storeUserRegistration'])->name('events.store-registration');
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

    // Mostrar detall esdeveniment
    Route::get('admin/esdeveniments/{esdeveniment}', [EsdevenimentController::class, 'show'])->name('esdeveniment.show');

    // Volt routes removed - using controller routes instead

    // Codis QR
    Route::prefix('qr')->group(function () {
        Route::get('/create', [QrCodeController::class, 'create'])->name('qr.create');
        Route::post('/create', [QrCodeController::class, 'store'])->name('qr.store');
        Route::post('/send-massive', [QrCodeController::class, 'sendMassive'])->name('qr.send.massive');
        Route::get('/read', [QrCodeController::class, 'read'])->name('qr.read');
        Route::post('/decode', [QrCodeController::class, 'decode'])->name('qr.decode');
        Route::get('/scanner', [QrCodeController::class, 'scanner'])->name('qr.scanner');
        Route::post('/process-scan', [QrCodeController::class, 'processScan'])->name('qr.process');
    });

    // Gestió de Cursos
    Route::prefix('admin/cursos')->name('cursos.')->group(function () {
        Route::get('/', [\App\Http\Controllers\CursController::class, 'index'])->name('index');
        Route::get('/crear', [\App\Http\Controllers\CursController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\CursController::class, 'store'])->name('store');
        Route::get('/{curs}/editar', [\App\Http\Controllers\CursController::class, 'edit'])->name('edit');
        Route::put('/{curs}', [\App\Http\Controllers\CursController::class, 'update'])->name('update');
        Route::delete('/{curs}', [\App\Http\Controllers\CursController::class, 'destroy'])->name('destroy');
        Route::post('/{curs}/toggle', [\App\Http\Controllers\CursController::class, 'toggleActivo'])->name('toggle');
    });

    // Gestió d'Assistents per Esdeveniment
    Route::prefix('admin/esdeveniments/{esdeveniment}/assistents')->name('esdeveniments.assistents.')->group(function () {
        Route::get('/', [\App\Http\Controllers\EsdevenimentAssistentController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\EsdevenimentAssistentController::class, 'store'])->name('store');
        Route::post('/massive', [\App\Http\Controllers\EsdevenimentAssistentController::class, 'assignMassive'])->name('massive');
        Route::put('/{assistent}', [\App\Http\Controllers\EsdevenimentAssistentController::class, 'update'])->name('update');
        Route::delete('/{assistent}', [\App\Http\Controllers\EsdevenimentAssistentController::class, 'destroy'])->name('destroy');
    });

    // Control d'accessos (Lector QR) - redirect to scanner
    Route::get('lector-qr', function () {
        return redirect()->route('qr.scanner');
    })->name('lector_qr');

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
    Route::get('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('status', 'Has tancat sessió correctament.');
    })->name('logout_get');

});