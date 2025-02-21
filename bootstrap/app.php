<?php

use App\Exceptions\ResourceNotFoundException;
use App\Http\Middleware\AdminAccessMiddleware;
use App\Http\Middleware\CancellationOfBookingMiddleware;
use App\Http\Middleware\DraftResourceMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api()->alias([
            'draftResource' => DraftResourceMiddleware::class,
            'isAdmin' => AdminAccessMiddleware::class,
            'cancelBooking' => CancellationOfBookingMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ResourceNotFoundException $e) {
            return responseFailed($e->getMessage(), $e->getCode());
        });
        $exceptions->renderable(function (NotFoundHttpException $e) {
            return responseFailed(__('messages.route_not_found'), 404);
        });
    })->create();
