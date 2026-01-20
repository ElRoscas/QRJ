<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPerm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Si no está autenticado, redirigir al login
        if (!$user) {
            return redirect()->route('login');
        }

        // Verificar si tiene el permiso de admin (PermCode = '11111')
        $hasAdminPerm = $user->permissos()->where('PermCode', '11111')->exists();

        if (!$hasAdminPerm) {
            // Si no tiene permisos, redirigir a menu de usuario
            return redirect()->route('menu_user');
        }

        return $next($request);
    }
}
