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
        // Trust all proxies when env var TRUSTED_PROXIES is '*', else pass CSV/IP list
        $proxies = env('TRUSTED_PROXIES');
        if ($proxies) {
            if ($proxies === '*') {
                $middleware->trustProxies(at: '*');
            } else {
                $list = array_map('trim', explode(',', $proxies));
                $middleware->trustProxies(at: $list);
            }
        }
        // Optionally set forwarded headers explicitly (Laravel picks sane defaults otherwise)
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
