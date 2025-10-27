<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255|unique:categories,name',
            'desc'  => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'اسم الفئة مطلوب.',
            'name.string'      => 'يجب أن يكون اسم الفئة نصًا.',
            'name.max'         => 'اسم الفئة لا يجب أن يتجاوز 255 حرفًا.',
            'name.unique'      => 'اسم الفئة موجود بالفعل.',
            'desc.string'      => 'الوصف يجب أن يكون نصًا.',
            'desc.max'         => 'الوصف لا يجب أن يتجاوز 500 حرف.',
            'image.mimes'      => 'يجب أن تكون الصورة من نوع JPEG أو PNG أو WEBP',
            'image.max'        => 'حجم الصورة لا يجب أن يتجاوز 2 ميجابايت',
        ];
    }
}
