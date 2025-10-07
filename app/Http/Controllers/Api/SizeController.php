<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SizeResource;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
    {
        $sizes = Size::all();

        if (!$sizes->isEmpty()) {
            return ApiResponse::SendResponse(404 , ' Not Found size' , []);
        }else{

            return ApiResponse::SendResponse(200 , 'sizes retrived successfully' , SizeResource::collection($sizes));
        }

    }

}
