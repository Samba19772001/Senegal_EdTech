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
        // Exclure les routes admin de la vérification CSRF
        $middleware->validateCsrfTokens(except: [
            'admin/*',
        ]);

        $middleware->alias([
            'admin'       => \App\Http\Middleware\AdminMiddleware::class,
            'not.blocked' => \App\Http\Middleware\CheckUserNotBlocked::class,
        ]);

        $middleware->appendToGroup('web', \App\Http\Middleware\CheckUserNotBlocked::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();