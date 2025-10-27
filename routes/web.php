<?php

use App\Http\Controllers\Dashboard\CategoryController;
use Illuminate\Support\Facades\Route;




Route::get('categories' , [ CategoryController::class , 'index']);





Route::get('/', function () {
    return view('welcome');
});
