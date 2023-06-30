<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next, $permission)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar si el usuario tiene el permiso necesario
        if (!$user || !$this->hasPermission($user, $permission)) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }

    private function hasPermission($user, $permission): bool
    {
        // Implementa aquí la lógica de verificación de permisos según tus necesidades

        if ($user->isSuperUser()) {
            return true;
        }

        if ($permission === 'admin') {
            return !$user->isAdmin();
        }

        if ($permission === 'user') {
            return $user->isSuperUser() || $user->isAdmin();
        }

        return false;
    }
}
