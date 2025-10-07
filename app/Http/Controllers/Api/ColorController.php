<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    public function index()
    {
        $colors = Color::all();
        if (!$colors->isEmpty()) {
            return ApiResponse::SendResponse(404 , ' Not Found color' , []);
        }
        return ApiResponse::SendResponse(200 , 'colors retrived successfully' , ColorResource::collection($colors));
    }


}
