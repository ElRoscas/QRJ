<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController
{
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'Correu' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('Correu', $credentials['Correu'])->first();

        if ($user && Hash::check($credentials['password'], $user->Contrasenya)) {
            Auth::login($user, $request->boolean('remember'));

            // Redirigir según permisos
            $hasAdminPerm = $user->permissos()
                ->where('PermCode', '11111')
                ->exists();

            return $hasAdminPerm
                ? redirect()->route('menu_admin')
                : redirect()->route('menu_user');
        }

        return back()->withErrors([
            'Correu' => 'Les credencials no coincideixen amb els nostres registres.',
        ])->onlyInput('Correu');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
