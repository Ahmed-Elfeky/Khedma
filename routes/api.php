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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
 API Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/products/filter', [ProductController::class, 'filter']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('products/update/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('favourites', FavouriteController::class);
    // Cart Routes //
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart', [CartController::class, 'store']);
    Route::delete('cart/{id}', [CartController::class, 'destroy']);

    // Orders Routes //
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::post('orders', [OrderController::class, 'store']);
});


Route::get('home', [HomeController::class, 'index']);

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('send-otp', 'sendOtp');
    Route::post('verify-otp', 'verifyOtp');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::apiResource('banners', BannerController::class);
Route::get('categories', [CategoryController::class, 'index']);
Route::get('colors', [ColorController::class, 'index']);
Route::get('sizes', [SizeController::class, 'index']);
Route::get('cities', [CityController::class, 'index']);
Route::get('products/by-category', [ProductController::class, 'getByCategory']);
Route::post('complaints', [ComplaintController::class, 'store']);
