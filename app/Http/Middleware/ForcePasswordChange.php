<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->must_change_password) {
            // Prevent infinite redirect loops by allowing them to access the password change page and logout route
            if (!$request->routeIs('password.force.change') && !$request->routeIs('password.force.update') && !$request->routeIs('logout')) {
                return redirect()->route('password.force.change');
            }
        }

        return $next($request);
    }
}