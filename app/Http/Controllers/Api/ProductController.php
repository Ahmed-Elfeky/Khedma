<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductByCategoryRequest;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\ProductResource;
use App\Models\Color;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{



    public function index()
    {
        // استخدمت with عشان يبعت العلاقات مع المنتج في query واحدهبيكون اسرع
        $products = Product::with(['images', 'colors', 'sizes'])->paginate(10);;
        if (!$products) {
            return ApiResponse::SendResponse(400, 'Not Product Found', []);
        }
        return ApiResponse::SendResponse(
            200,
            'product Retrived Succsessfully',
            [
                'products' => ProductResource::collection($products->items()),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page'    => $products->lastPage(),
                    'total'        => $products->total(),
                ]
            ]
        );
    }

    public function store(ProductRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $data['user_id'] = auth()->id() ?? 1;
        // if ($user->role !== 'company') {
        //     return ApiResponse::SendResponse(403, 'Access denied. Only companies can add products.', []);
        // }
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/' . $imageName;
        }
        $product = Product::create($data);

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $img) {
                $imgName = uniqid() . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('uploads/products'), $imgName);
                $images[] = ['image' => 'uploads/products/' . $imgName];
            }
            $product->images()->createMany($images);
        }
        if ($request->has('colors')) {
            $colorIds = [];
            foreach ($request->colors as $hex) {
                $color = Color::firstOrCreate(['hex' => $hex]);
                $colorIds[] = $color->id;
            }
            $product->colors()->sync($colorIds);
        }
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

    public function update(UpdateProductRequest $request, $product)
    {
        $product = Product::find($product);
        $data = $request->validated();
        if (!$product) {
            return ApiResponse::SendResponse(404, 'Product not found', []);
        }
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/' . $imageName;

            if (!empty($product->image) && file_exists(public_path($product->image))) {
                @unlink(public_path($product->image));
            }
        }
        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($product->images as $img) {
                if (file_exists(public_path($img->image))) {
                    @unlink(public_path($img->image));
                }
                $img->delete();
            }
            foreach ($request->file('images') as $imageFile) {
                $imageName = time() . '_' . uniqid() . '.' . $imageFile->extension();
                $imageFile->move(public_path('uploads/products'), $imageName);

                $product->images()->create([
                    'image' => 'uploads/products/' . $imageName,
                ]);
            }
        }

        if ($request->has('colors')) {
            $colorIds = [];
            foreach ($request->colors as $hex) {
                $color = Color::firstOrCreate(['hex' => $hex]);
                $colorIds[] = $color->id;
            }
            $product->colors()->sync($colorIds);
        }

        if ($request->has('sizes')) {
            $sizeIds = [];
            foreach ($request->sizes as $name) {
                $size = Size::firstOrCreate(['name' => $name]);
                $sizeIds[] = $size->id;
            }
            $product->sizes()->sync($sizeIds);
        }
        $product->refresh();
        return ApiResponse::SendResponse(
            200,
            'Product updated successfully',
            new ProductResource($product->load('images', 'colors', 'sizes'))
        );
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return ApiResponse::SendResponse(400, 'Not Product Found', []);
        }
        return ApiResponse::SendResponse(200, 'product Retrived Succsessfully', new ProductResource($product));
    }

    public function getByCategory(ProductByCategoryRequest $request)
    {

        $category_id = $request->query('category_id');
        $subcategoryIds = SubCategory::where('category_id', $category_id)->pluck('id');
        $products = Product::with(['images', 'colors', 'sizes'])
            ->whereIn('subcategory_id', $subcategoryIds)->get();
        if ($products->isEmpty()) {
            return ApiResponse::SendResponse(404, 'Not Product Found', []);
        }
        return ApiResponse::SendResponse(200, 'Products fetched successfully', ProductResource::collection($products));
    }

    public function destroy($id)
    {
        //  البحث عن المنتج مع الصور لتقليل الاستعلامات
        $product = Product::with('images')->find($id);
        if (!$product) {
            return ApiResponse::SendResponse(404, 'Product not found', []);
        }
        if (Auth::id() !== $product->user_id) {
            return ApiResponse::SendResponse(403, 'You are not authorized to delete this product', []);
        }
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        foreach ($product->images as $image) {
            $imagePath = public_path($image->image);
            if ($image->image && file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();
        }
        $product->colors()->detach();
        $product->sizes()->detach();
        $product->delete();
        return ApiResponse::SendResponse(200, 'Product deleted successfully');
    }

    public function filter(FilterRequest $request)
    {
        $filters = $request->validated();

        $query = Product::with(['images', 'colors', 'sizes']);

        if (isset($filters['min_price']) && isset($filters['max_price'])) {
            $query->whereBetween('price', [$filters['min_price'], $filters['max_price']]);
        } elseif (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        } elseif (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        $products = $query->latest()->paginate(10);

        if ($products->isEmpty()) {
            return ApiResponse::SendResponse(404, 'No products found for the selected filters', []);
        }

        return ApiResponse::SendResponse(
            200,
            'Products filtered successfully',
            ProductResource::collection($products)
        );
    }
}
