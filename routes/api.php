<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;

Route::get('admin/login', [LoginController::class, 'login']);
