<?php

use Houtu\Enums\AdminErrorCode;
use Houtu\Helpers\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, $request) {
            return ApiResponse::error(
                $e->validator->errors()->first(),
                AdminErrorCode::VALIDATION_FAILED,
                422
            );
        });

        //todo Authentication

        //todo Authorization

        //todo NotFound

        //todo MethodNotAllowed

        $exceptions->render(function (Throwable $e, $request) {
            return ApiResponse::error($e->getMessage(), AdminErrorCode::SERVER_ERROR, 500);
        });
    })->create();
