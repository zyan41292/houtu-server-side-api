<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Houtu\Enums\AdminErrorCode;
use Houtu\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function store(Request $request)
    {

            $validated = $request->validate([
                'account'  => 'required|string|max:50|unique:admins,account',
                'password' => 'required|string|min:6',
                'name'     => 'required|string|max:100',
                'phone'    => 'required|string|max:20|unique:admins,phone',
                'email'    => 'required|email|unique:admins,email',
            ]);


        // 对密码进行加密
        $validated['password'] = Hash::make($validated['password']);
        $validated['reg_ip'] = $request->ip();

        $admin = Admin::create($validated);

        return ApiResponse::success($admin,'creat success');
    }
}
