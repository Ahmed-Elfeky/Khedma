<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SizeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
 API Routes
|--------------------------------------------------------------------------
|
*/
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



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
