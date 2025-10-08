<?php

namespace App\Http\Controllers\Admin;

use App\Services\System\AuthService;
use Houtu\Base\BaseController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends BaseController
{
    protected AuthService $services;

    public function __construct(AuthService $services)
    {
        $this->services = $services;
    }
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

        $data = $this->services->login($validated);
        return $this->success($data);
    }

    public function show()
    {
        $data = $this->services->show();
        return $this->success($data);
    }

    public function permission()
    {
        $data = $this->services->permission();
        return $this->success($data);
    }

    public function logout()
    {
        $data = $this->services->logout();
        return $this->success($data);
    }

}
