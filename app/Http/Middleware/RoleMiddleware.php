<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = auth()->user();

        if (!$user || !$user->roles->contains('name', $role)) {
            abort(403, 'No autorizado');
        }

        return $next($request);
    }
}