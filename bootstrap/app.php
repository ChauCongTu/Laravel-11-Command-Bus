<?php

use App\Constants\ResponseMessage;
use App\Exceptions\AuthException;
use App\Exceptions\NotFoundException;
use App\Http\Middleware\CheckAuthorization;
use App\Http\Middleware\RoleCheck;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'Role' => RoleCheck::class,
            'Authorized' => CheckAuthorization::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->report(function (Throwable $e) {
        //     // throw new NotFoundException(ResponseMessage::NOT_FOUND);
        //     throw new AuthException(ResponseMessage::UNAUTHORIZED);
        // });
        // $exceptions->render(function (UnauthorizedException $e, Request $request) {
        //     throw new AuthException(ResponseMessage::UNAUTHORIZED);
        // });
    })->create();
