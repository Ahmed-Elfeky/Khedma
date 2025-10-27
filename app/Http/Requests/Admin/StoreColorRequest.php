<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'hex'  => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'hex.required' => 'كود اللون مطلوب',
            'hex.regex'    => 'صيغة كود اللون غير صحيحة (مثال: #FF0000)',
        ];
    }
}
