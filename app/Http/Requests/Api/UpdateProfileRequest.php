<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // السماح لكل المستخدمين المسجلين
        return true;
    }

    public function rules(): array
    {
        // نحمي الكود من null في حالة user غير معروف
        $userId = optional($this->user())->id;

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($userId)],
            'password' => ['sometimes', 'confirmed', 'min:6'],
            'logo' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'الاسم يجب أن يكون نصًا صحيحًا.',
            'name.max' => 'الاسم لا يمكن أن يتجاوز 255 حرفًا.',
            'phone.unique' => 'رقم الهاتف مستخدم من قبل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
            'password.min' => 'كلمة المرور يجب ألا تقل عن 6 أحرف.',
            'logo.image' => 'الملف يجب أن يكون صورة.',
            'logo.mimes' => 'الصورة يجب أن تكون بصيغة JPG أو PNG أو WEBP.',
            'logo.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت.',
        ];
    }
}
