<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('admin/login', [\App\Http\Controllers\Admin\LoginController::class, 'login']);
Route::get('admin/show', [\App\Http\Controllers\Admin\LoginController::class, 'show'])->middleware('jwt-auth') ->middleware('role:admin');
Route::get('admin/permission', [\App\Http\Controllers\Admin\LoginController::class, 'permission'])->middleware('jwt-auth') ->middleware('role:admin');
Route::post('admin/logout', [\App\Http\Controllers\Admin\LoginController::class, 'logout'])->middleware('jwt-auth') ->middleware('role:admin');


Route::get('system/role', [\App\Http\Controllers\Admin\System\RolesController::class, 'index'])->middleware('jwt-auth') ->middleware('role:admin');
Route::post('system/role', [\App\Http\Controllers\Admin\System\RolesController::class, 'store'])->middleware('jwt-auth') ->middleware('role:admin');
Route::get('system/role/{id}', [\App\Http\Controllers\Admin\System\RolesController::class, 'show'])->middleware('jwt-auth') ->middleware('role:admin');
Route::put('system/role/{id}', [\App\Http\Controllers\Admin\System\RolesController::class, 'update'])->middleware('jwt-auth')->middleware('role:admin');
Route::delete('system/role/{id}', [\App\Http\Controllers\Admin\System\RolesController::class, 'destroy'])->middleware('jwt-auth')->middleware('role:admin');


Route::get('system/menu', [\App\Http\Controllers\Admin\System\MenuController::class, 'index'])->middleware('jwt-auth') ->middleware('role:admin');
Route::post('system/menu', [\App\Http\Controllers\Admin\System\MenuController::class, 'store'])->middleware('jwt-auth') ->middleware('role:admin');
Route::get('system/menu/{id}', [\App\Http\Controllers\Admin\System\MenuController::class, 'show'])->middleware('jwt-auth') ->middleware('role:admin');
Route::put('system/menu/{id}', [\App\Http\Controllers\Admin\System\MenuController::class, 'update'])->middleware('jwt-auth')->middleware('role:admin');
Route::delete('system/menu/{id}', [\App\Http\Controllers\Admin\System\MenuController::class, 'destroy'])->middleware('jwt-auth')->middleware('role:admin');

Route::post('admin/store', [AdminController::class, 'store']);
/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/
