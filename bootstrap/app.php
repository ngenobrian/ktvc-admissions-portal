<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'force_password_change' => \App\Http\Middleware\ForcePasswordChange::class,
        ]);

        $middleware->redirectUsersTo(function (\Illuminate\Http\Request $request) {
            $user = auth()->user();
            
            if ($user && ($user->hasAnyRole(['Super Admin', 'Registrar']) || $user->permissions->count() > 0)) {
                return route('admin.dashboard');
            }

            return route('dashboard');
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();