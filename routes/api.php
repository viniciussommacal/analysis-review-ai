<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\UserIsAdminMiddleware;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(JwtMiddleware::class)->group(function () {
    Route::middleware(UserIsAdminMiddleware::class)->group(function () {
        Route::apiResource('category', CategoryController::class);
        Route::apiResource('product', ProductController::class)->except(['index', 'show']);
    });
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::apiResource('product', ProductController::class)->only(['index', 'show']);
