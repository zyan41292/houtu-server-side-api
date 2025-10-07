<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Houtu\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWTGuard;

class LoginController extends Controller
{
    /**
     * this is the first API of my project which is a customized server-side API for e-commerce applications.
     * this API is used to log in to the system.
     * let's start
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'account' => 'required',
            'password' => 'required|min:6'
        ]);

        if (!$token = JWTAuth::attempt($validated)) {
            return ApiResponse::error('Invalid credentials', 401);
        }

        return ApiResponse::success([
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60 // 默认 1 小时
        ]);
    }
}
