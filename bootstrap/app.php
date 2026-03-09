<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Adminmiddleware;
use App\Http\Middleware\Customermiddleware;
use App\Http\Middleware\Sellermiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => Adminmiddleware::class,
            'customer' => Customermiddleware::class,
            'seller' => Sellermiddleware::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'role'=> \App\Http\Middleware\CheckRole::class,
            'emplee'=> \App\Http\Middleware\EmpleeMiddleware::class,
            'manager'=> \App\Http\Middleware\ManagerMiddleware::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
