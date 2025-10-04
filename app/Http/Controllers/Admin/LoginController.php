<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * this is the first API of my project which is a customized server-side API for e-commerce applications.
     * this API is used to log in to the system.
     * let's start
     */
    public function login()
    {
        return response()->json(['message' => 'login']);
    }
}
