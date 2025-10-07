<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        $products = Product::all();
        $categories = Category::all();

        $data = [
            'banners'    => BannerResource::collection($banners),
            'categories' => CategoryResource::collection($categories),
            'products'   => ProductResource::collection($products),
        ];
        return ApiResponse::SendResponse(200, 'Home data fetched successfully', $data);
    }
}
