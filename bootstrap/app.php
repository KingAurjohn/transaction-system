<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminAuthentication;
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
            'adminauth'=>AdminAuthentication::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();