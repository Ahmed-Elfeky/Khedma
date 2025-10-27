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
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\SizeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =================== Public Routes (بدون تسجيل دخول) =================== //
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
Route::get('ratings/{productId}', [RatingController::class, 'index']);

// =================== Authentication Routes =================== //
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('send-otp', 'sendOtp');
    Route::post('verify-otp', 'verifyOtp');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

/// =================== Protected Routes (تحتاج تسجيل دخول) =================== ///
Route::middleware('auth:sanctum')->group(function () {
    Route::post('profile-update', [AuthController::class, 'updateProfile']);

    // ---------- Routes لجميع المستخدمين بعد تسجيل الدخول ---------- //
    Route::get('orders/filter', [OrderController::class, 'filterOrders']);
    Route::get('orders/current', [OrderController::class, 'currentOrders']);
    Route::get('orders/previous', [OrderController::class, 'previousOrders']);
    Route::get('orders/companyOrderedProducts', [OrderController::class, 'companyOrderedProducts']);

    Route::apiResource('favourites', FavouriteController::class);
    Route::get('cart', [CartController::class, 'index']);
    Route::delete('cart/{id}', [CartController::class, 'destroy']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{id}', [OrderController::class, 'show']);


    // ---------- User Routes (محمي بـ middleware user) ---------- //
    Route::middleware('user')->group(function () {
        Route::post('orders', [OrderController::class, 'store']);
        Route::get('my-orders', [OrderController::class, 'myOrders']);
        Route::post('cart', [CartController::class, 'store']);
    });

    // ---------- Company Routes (محمي بـ middleware company) ---------- //
    Route::middleware('company')->group(function () {
        Route::post('products/store', [ProductController::class, 'store']);
        Route::post('products/update/{id}', [ProductController::class, 'update']);
        Route::delete('products/destroy/{id}', [ProductController::class, 'destroy']);
    });
        Route::post('ratings', [RatingController::class, 'store']);

});
