<?php

use App\Http\Middleware\JwtAuthenticate;
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
        $middleware->alias([
            'jwt-auth' => JwtAuthenticate::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
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
        $exceptions->render(function (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e, $request) {
            return ApiResponse::error($e->getMessage(), AdminErrorCode::TOKEN_EXPIRED, 500);
        });
        $exceptions->render(function (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e, $request) {
            return ApiResponse::error($e->getMessage(), AdminErrorCode::TOKEN_INVALID, 500);
        });
        $exceptions->render(function (\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e, $request) {
            return ApiResponse::error($e->getMessage(), AdminErrorCode::TOKEN_NOT_FOUND, 500);
        });
        $exceptions->render(function (\Tymon\JWTAuth\Exceptions\JWTException $e, $request) {
            return ApiResponse::error($e->getMessage(), AdminErrorCode::TOKEN_NOT_FOUND, 500);
        });

        //todo Authorization

        //todo NotFound

        //todo MethodNotAllowed

        $exceptions->render(function (Throwable $e, $request) {
            return ApiResponse::error($e->getMessage(), AdminErrorCode::SERVER_ERROR, 500);
        });
    })->create();
