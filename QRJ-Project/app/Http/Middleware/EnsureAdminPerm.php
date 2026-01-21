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
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Obtener el usuario actual
        $user = auth()->user();

        // Verificar si el usuario tiene permisos de admin (PermCode = '11111')
        $hasAdminPerm = $user->permissos()
            ->where('PermCode', '11111')
            ->exists();

        // Si NO tiene permisos, redirigir a menu_user
        if (!$hasAdminPerm) {
            return redirect()->route('menu_user')
                ->with('status', 'No tens permisos d\'administrador.');
        }

        return $next($request);
    }
}
