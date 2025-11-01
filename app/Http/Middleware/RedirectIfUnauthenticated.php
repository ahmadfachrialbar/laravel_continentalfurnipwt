<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfUnauthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            session(['redirect_after_login' => $request->fullUrl()]);
            return redirect()->route('login')->with('info', 'Silakan login untuk melanjutkan checkout.');
        }

        return $next($request);
    }
}
