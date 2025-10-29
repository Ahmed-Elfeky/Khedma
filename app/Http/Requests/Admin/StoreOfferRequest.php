<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
          return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'يجب اختيار القسم المرتبط بالعرض.',
            'category_id.exists' => 'القسم المحدد غير موجود.',
            'title.required' => 'يجب إدخال عنوان العرض.',
            'type.in' => 'نوع الخصم يجب أن يكون نسبة مئوية أو مبلغ ثابت.',
            'value.required' => 'يجب تحديد قيمة الخصم.',
            'end_date.after_or_equal' => 'تاريخ نهاية العرض يجب أن يكون بعد أو يساوي تاريخ البداية.',
        ];
    }
}
