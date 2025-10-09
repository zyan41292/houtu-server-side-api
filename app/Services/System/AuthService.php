<?php

namespace App\Services\System;

use App\Services\BaseService;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends BaseService
{
    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
    }

    public function login($data)
    {
        if (!$token = JWTAuth::attempt($data)) {
            throw new \Illuminate\Auth\AuthenticationException('Account or password is incorrect.');
        }

        return [
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->getTTL()
        ];
    }

    public function getTTL(): int
    {
        return Auth::guard('api')->factory()->getTTL() * 60;
    }

    public function show()
    {
        $data = Auth::user();
        return [
            'admin_info' => $data->only(['id', 'name', 'email']),
            'roles' => $data->getRoleNames()
        ];
    }

    public function permission()
    {
        $data = Auth::user();
        return $data->getAllPermissions();
    }

    public function isLogin()
    {
        $user = JWTAuth::parseToken()->authenticate();
        Auth::setUser($user);
        return true;
    }

    public function __call($method, $arguments)
    {
        $guard = Auth::guard();
        if (method_exists($guard, $method)) {
            return $guard->$method(...$arguments);
        }

        if (method_exists(Auth::class, $method)) {
            return Auth::$method(...$arguments);
        }

        throw new \BadMethodCallException("Method {$method} does not exist in Auth.");
    }
}
