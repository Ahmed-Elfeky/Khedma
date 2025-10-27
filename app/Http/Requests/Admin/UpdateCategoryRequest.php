<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($this->category),
            ],
            'desc' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الفئة مطلوب.',
            'name.unique' => 'اسم الفئة مستخدم بالفعل.',
            'name.max' => 'اسم الفئة لا يجب أن يتجاوز 255 حرفًا.',
            'description.max' => 'الوصف لا يجب أن يتجاوز 500 حرف.',
        ];
    }
}
