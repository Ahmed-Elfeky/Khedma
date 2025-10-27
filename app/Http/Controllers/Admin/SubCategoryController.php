<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubCategoryRequest;
use App\Http\Requests\Admin\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcat = SubCategory::with('category')->latest()->paginate(6);;
        return view('admin.subcategories.index', compact('subcat'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.subCategories.create', compact('categories'));
    }

    public function store(StoreSubCategoryRequest $request)
    {
        $data = $request->validated();
        SubCategory::create($data);
        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Sub Category created successfully');
    }

    public function edit($id)
    {
        $subcat = SubCategory::findOrFail($id);
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcat', 'categories'));
    }


    public function update(UpdateSubCategoryRequest $request, SubCategory $subcategory)
    {
        $data = $request->validated();
        $subcategory->update($data);
        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Sub Category updated successfully');
    }


    public function destroy($id)
    {
        $subcat = SubCategory::findOrFail($id);
        $subcat->delete();
        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Sub Category deleted successfully');
    }
}
