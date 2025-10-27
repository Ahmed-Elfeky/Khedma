<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
           'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subcategories', 'name')->ignore($this->subcategory->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'يجب اختيار فئة رئيسية.',
            'category_id.exists' => 'الفئة المحددة غير موجودة.',
            'name.required' => 'اسم الفئة الفرعية مطلوب.',
            'name.unique' => 'اسم الفئة الفرعية مستخدم بالفعل.',
            'name.max' => 'اسم الفئة الفرعية لا يجب أن يتجاوز 255 حرفًا.',
        ];
    }
}
