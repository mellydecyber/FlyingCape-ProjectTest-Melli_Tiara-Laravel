<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use Closure;
use Illuminate\Http\Request;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role !== Roles::STUDENT) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
