<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('admin/login', [\App\Http\Controllers\Admin\LoginController::class, 'login']);
Route::post('admin/store', [AdminController::class, 'store']);
/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/
