<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        App\Providers\ServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register custom middleware
        $middleware->alias([
            'language' => \App\Http\Middleware\LanguageMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'admin.web' => \App\Http\Middleware\AdminWebMiddleware::class,
        ]);

        // Apply language middleware to API routes
        $middleware->api(append: [
            \App\Http\Middleware\LanguageMiddleware::class,
        ]);

        // Enable CORS for API routes
        // $middleware->api(prepend: [
        //     \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
