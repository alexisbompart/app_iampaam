<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            // Redirigir a la página apropiada según el rol del usuario
            $userRole = auth()->user()->role;
            if ($userRole === 'operador' || $userRole === 'consultor') {
                return redirect()->route('beneficiarios.index');
            }
            abort(403, 'Acceso denegado.');
        }

        return $next($request);
    }
}
