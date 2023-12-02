<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user() || auth()->user()->role !== Roles::ADMIN) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
