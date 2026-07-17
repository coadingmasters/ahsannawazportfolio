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
    ->withMiddleware(function (Middleware $middleware): void {
        // The auth middleware defaults to a route named "login"; ours is
        // "admin.login", so without this guests hit a RouteNotFoundException.
        $middleware->redirectGuestsTo(fn () => route('admin.login'));

        // Likewise, send already-authenticated users to the admin dashboard
        // rather than the framework's default "/dashboard".
        $middleware->redirectUsersTo(fn () => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
