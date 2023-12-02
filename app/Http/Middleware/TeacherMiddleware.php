<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use Closure;
use Illuminate\Http\Request;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role !== Roles::TEACHER) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
