<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SizeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

//  Public Routes (بدون تسجيل دخول)
Route::get('home', [HomeController::class, 'index']);
Route::get('banners', [BannerController::class, 'index']);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('colors', [ColorController::class, 'index']);
Route::get('sizes', [SizeController::class, 'index']);
Route::get('cities', [CityController::class, 'index']);
Route::get('products/by-category', [ProductController::class, 'getByCategory']);
Route::get('products/filter', [ProductController::class, 'filter']);
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('complaints', [ComplaintController::class, 'store']);

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('send-otp', 'sendOtp');
    Route::post('verify-otp', 'verifyOtp');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

// Routes for logged-in users
Route::middleware('auth:sanctum')->group(function () {
    //  User routes
    Route::apiResource('favourites', FavouriteController::class);
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart', [CartController::class, 'store']);
    Route::delete('cart/{id}', [CartController::class, 'destroy']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::post('orders', [OrderController::class, 'store']);

    //  Company routes (protected by middleware company)
    Route::middleware('company')->group(function () {
        Route::post('products/store', [ProductController::class, 'store']);
        Route::post('products/update/{id}', [ProductController::class, 'update']);
        Route::delete('products/destroy/{id}', [ProductController::class, 'destroy']);
    });

    //  Admin routes (optional future use)
    Route::middleware('admin')->group(function () {
    //     // admin-specific routes
    //     Route::get('admin/dashboard', [AdminController::class, 'dashboard']);
    // Route::delete('admin/delete-user/{id}', [AdminController::class, 'destroyUser']);
    });
});
