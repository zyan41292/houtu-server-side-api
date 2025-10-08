<?php

namespace Houtu\Base;

use App\Http\Controllers\Controller;
use Houtu\Helpers\ApiResponse;

class BaseController extends Controller
{
    protected function success($data = null, $message = 'Success', $code = 200)
    {
        return ApiResponse::success($data, $message, $code);
    }

    protected function error($message = 'Error', $code = 400, $data = null)
    {
        return ApiResponse::error($message, $code, $data);
    }
}
