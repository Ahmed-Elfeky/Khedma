<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        // ✅ الصورة الرئيسية
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/' . $imageName;
        }

        //  إنشاء المنتج أولاً
        $product = Product::create($data);

        //  رفع الصور الإضافية
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $img) {
                $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('uploads/products'), $imgName);
                $images[] = ['image' => 'uploads/products/' . $imgName];
            }
            $product->images()->createMany($images);
        }

        // ✅ الألوان
        if ($request->has('colors')) {
            $colorIds = [];
            foreach ($request->colors as $hex) {
                $color = Color::firstOrCreate(['hex' => $hex]);
                $colorIds[] = $color->id;
            }
            $product->colors()->sync($colorIds);
        }

        // ✅ المقاسات
        if ($request->has('sizes')) {
            $sizeIds = [];
            foreach ($request->sizes as $sizeName) {
                $size = Size::firstOrCreate(['name' => $sizeName]);
                $sizeIds[] = $size->id;
            }
            $product->sizes()->sync($sizeIds);
        }

        return ApiResponse::SendResponse(
            201,
            'Product added successfully',
            new ProductResource($product->load('images', 'colors', 'sizes'))
        );
    }
}
