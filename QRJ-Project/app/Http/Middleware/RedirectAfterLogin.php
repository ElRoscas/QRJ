<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAfterLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Si el login fue exitoso (está autenticado ahora)
        if (auth()->check() && $request->path() === 'login' && $request->isMethod('post')) {
            $user = auth()->user();
            $hasAdminPerm = $user->permissos()
                ->where('PermCode', '11111')
                ->exists();

            return $hasAdminPerm
                ? redirect()->route('menu_admin')
                : redirect()->route('menu_user');
        }

        return $response;
    }
}
