<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'name' => 'required|string|max:255|unique:products,name',
            'user_id' => 'required|exists:users,id',
            'desc' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0',
            'guarantee' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
        ];
    }
}
