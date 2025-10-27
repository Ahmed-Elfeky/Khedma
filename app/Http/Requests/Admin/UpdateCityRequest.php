<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCityRequest extends FormRequest
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
                Rule::unique('cities', 'name')->ignore($this->city),
            ],            'shipping_price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم المدينة مطلوب',
            'name.unique' => 'اسم المدينة موجود بالفعل',
            'shipping_price.required' => 'سعر الشحن مطلوب',
            'shipping_price.numeric' => 'سعر الشحن يجب أن يكون رقمًا',
        ];
    }
}
