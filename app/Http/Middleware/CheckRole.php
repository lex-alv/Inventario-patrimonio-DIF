<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        if (!$request->user() || $request->user()->rol !== $rol) {
            abort(403, 'Acceso restringido: No cuenta con los privilegios normativos requeridos para esta acción.');
        }

        return $next($request);
    }
}