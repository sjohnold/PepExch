<?php

use App\Http\Middleware\CheckHasRootUser;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\UpdateLastActive;
use App\Http\Middleware\IdempotencyMiddleware;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo('/user/login');

        $middleware->validateCsrfTokens(except: [
            'aamarpay/payment/success',
            'aamarpay/payment/fail',
            'aamarpay/payment/cancel',
        ]);

        $middleware->appendToGroup('web', [
            SetLocale::class,
            UpdateLastActive::class,
            HandleInertiaRequests::class,
            SecurityHeaders::class,
        ]);

        $middleware->appendToGroup('api', [
            IdempotencyMiddleware::class,
        ]);

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'has_root_user' => CheckHasRootUser::class,
            'idempotency' => IdempotencyMiddleware::class,
        ]);
    })
    ->withEvents(discover: [
        __DIR__ . '/../app/Listeners',
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
