<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MakesureAdmin
{
    public function handle($request, Closure $next)
    {
        if (! Auth::guard('admin')->check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied.');
        }

        return $next($request);
    }
}
