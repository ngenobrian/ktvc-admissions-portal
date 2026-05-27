<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Ensure the user is logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 2. The Dynamic VIP Check: If they have a role and it is NOT a trainee, let them in
        if ($user->role && strtolower($user->role) !== 'trainee') {
            return $next($request);
        }

        // 3. Otherwise, they are a student. Send them to the trainee dashboard.
        return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
    }
}