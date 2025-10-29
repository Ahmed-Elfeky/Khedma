<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CityController as AdminCityController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SubCategoryController as AdminSubCategoryController;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('sizes', SizeController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('cities', AdminCityController::class);
    Route::resource('products', ProductController::class);
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
