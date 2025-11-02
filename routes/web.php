<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CityController as AdminCityController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategoryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome')->name('dashboard');
});


// Route::prefix('admin')->middleware('admin')->group(function () {
//     Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });


// Route::prefix('admin')->middleware(['role.permission:add_product'])->group(function () {
//     Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });
Route::prefix('admin')->middleware(['auth:web', 'role:admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('sizes', SizeController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('cities', AdminCityController::class);
    Route::resource('products', ProductController::class)->middleware('role.permission:add_product');;
    Route::resource('offers', OfferController::class);
    Route::resource('users', UserController::class);
    Route::post('users/{user}/approve', [UserController::class, 'approve'])->name('admin.users.approve');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('subcategories', AdminSubCategoryController::class);
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');
    Route::put('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');
    Route::delete('products/images/{image}', [ProductController::class, 'destroyImage'])
        ->name('admin.products.images.destroy');
});
