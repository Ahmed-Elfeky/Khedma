<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\ProductImage;
use App\Models\User;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('subCategory')->latest()->paginate(6);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $subcategories = SubCategory::all();
        $colors = Color::all();
        $sizes = Size::all();
        $users = User::all();
        return view('admin.products.create', compact('subcategories', 'colors', 'sizes', 'users'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = Str::uuid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = $imageName;
        }
        $product = Product::create($data);
        $data['user_id'] = $request->user_id ?? Auth::id();

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = Str::uuid() . '.' . $file->extension();
                $file->move(public_path('uploads/products'), $imageName);
                $images[] = ['image' =>  $imageName];
            }
        }
        $product->images()->createMany($images);

        // Attach colors and sizes
        $product->colors()->sync($request->colors ?? []);
        $product->sizes()->sync($request->sizes ?? []);
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $subcategories = SubCategory::all();
        $colors = Color::all();
        $sizes = Size::all();
        $users = User::all();
        return view('admin.products.edit', compact('product', 'subcategories', 'colors', 'sizes', 'users'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image));
            }
            $imageName = Str::uuid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);
        if ($request->hasFile('images')) {

            //  حذف الصور القديمة (من الملفات + من جدول product_images)
            foreach ($product->images as $img) {
                $imagePath = public_path('uploads/products/' . $img->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $img->delete();
            }

            //  إضافة الصور الجديدة
            foreach ($request->file('images') as $file) {
                $imageName = Str::uuid() . '.' . $file->extension();
                $file->move(public_path('uploads/products'), $imageName);

                $product->images()->create([
                    'image' => $imageName,
                ]);
            }
        }

        $product->colors()->sync($request->colors ?? []);
        $product->sizes()->sync($request->sizes ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $subcategories = SubCategory::all();
        $colors = Color::all();
        $sizes = Size::all();
        $users = User::all();
        return view('admin.products.show', compact('product', 'subcategories', 'colors', 'sizes', 'users'));
    }

    public function destroy(Product $product)
    {
        if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
            unlink(public_path('uploads/products/' . $product->image));
        }

        // حذف الصور المتعددة (من جدول product_images)
        if ($product->images && $product->images->count() > 0) {
            foreach ($product->images as $img) {
                if (file_exists(public_path('uploads/products/' . $img->image))) {
                    unlink(public_path('uploads/products/' . $img->image));
                }
                $img->delete();
            }
        }
        $product->delete();
        return redirect()->route('admin.products.index');
    }


    public function destroyImage(ProductImage $image)
    {
        $path = public_path('uploads/products/' . $image->image);
        if (file_exists($path)) {
            unlink($path);
        }
        $image->delete();

        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
