<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user()->roleCheck($role)) {
            return $next($request);
        }
        abort(403, 'Unauthorized');
    }
}
