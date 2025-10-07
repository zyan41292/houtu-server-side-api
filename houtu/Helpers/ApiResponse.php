<?php

namespace Houtu\Helpers;

class ApiResponse
{
    public static function success($data = null, string $message = 'success', int $code = 200)
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ], 200);
    }

    public static function error(string $message = 'error', int $code = 10000, $httpStatus = 400)
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'data'    => null,
        ], $httpStatus);
    }
}
