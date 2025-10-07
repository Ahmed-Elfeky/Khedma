<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;

class BannerController extends Controller
{

    public function index()
    {
        $banners = Banner::all();
        return ApiResponse::SendResponse(200, 'ALL Banner Successfuly', BannerResource::collection($banners));
    }



}
