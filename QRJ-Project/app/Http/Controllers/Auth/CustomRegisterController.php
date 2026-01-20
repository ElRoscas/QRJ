<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomRegisterController extends Controller
{
    /**
     * Mostrar el formulari de registre.
     */
    public function create()
    {
        return view('livewire.auth.register');
    }

    /**
     * Registrar un usuari a la taula 'usuari'.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Comprovar si ja existeix
        if (User::where('Correu', $data['email'])->exists()) {
            return back()
                ->withErrors(['email' => 'Aquest correu ja existeix'])
                ->withInput();
        }

        $user = User::create([
            'Nom' => $data['name'],
            'Correu' => $data['email'],
            'Contrasenya' => Hash::make($data['password']),
            'Curs' => null,
        ]);

        Auth::login($user);

        return redirect()->route('menu_admin');
    }
}
