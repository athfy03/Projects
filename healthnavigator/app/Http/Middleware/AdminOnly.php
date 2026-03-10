<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            // Let 'auth' middleware handle login redirect
            abort(401);
        }

        if (!$user->is_admin) {
            abort(403, 'Admin only.');
        }

        return $next($request);
    }
}