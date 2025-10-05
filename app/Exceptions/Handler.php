<?php

namespace App\Exceptions;

use Houtu\Enums\AdminErrorCode;
use Houtu\Helpers\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return ApiResponse::error(
                $exception->validator->errors()->first(),
                AdminErrorCode::VALIDATION_FAILED,
                422
            );
        }

        //todo Authentication

        //todo Authorization

        return ApiResponse::error($exception->getMessage(), AdminErrorCode::SERVER_ERROR, 500);
    }
}
