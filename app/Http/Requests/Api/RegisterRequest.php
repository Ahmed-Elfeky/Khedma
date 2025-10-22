<?php

namespace App\Http\Requests\Api;

use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    //  إرجاع استجابة JSON عند حدوث خطأ فاليديشن
    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $response = ApiResponse::SendResponse(422, 'Validation errors', $validator->messages()->all());
            throw new ValidationException($validator, $response);
        }
    }

    public function rules(): array
    {
        return [
            'name'                     => 'required|string|max:255',
            'phone'                    => 'required|string|unique:users,phone',
            'password'                 => 'required|string|min:6|confirmed',
            'role'                     => 'required|in:admin,company,user',

            //  بيانات الشركة (لو role = company)
            'city_id'                  => 'required_if:role,company|exists:cities,id',
            'tax_number'               => 'required_if:role,company|string|max:255',
            'commercial_registration'  => 'required_if:role,company|string|max:255',
            'logo'                     => 'required_if:role,company|image|mimes:png,jpg,jpeg|max:2048',
            'address'                  => 'required_if:role,company|string',
            'website'                  => 'required_if:role,company|url|max:255',
            'latitude'                 => 'required_if:role,company|numeric|between:-90,90',
            'longitude'                => 'required_if:role,company|numeric|between:-180,180',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'              => 'الاسم مطلوب',
            'phone.required'             => 'رقم الهاتف مطلوب',
            'phone.unique'               => 'رقم الهاتف مسجل بالفعل',
            'password.required'          => 'كلمة المرور مطلوبة',
            'password.min'               => 'كلمة المرور يجب ألا تقل عن 6 أحرف',
            'password.confirmed'         => 'تأكيد كلمة المرور غير متطابق',
            'role.required'              => 'نوع المستخدم مطلوب (admin, company, user)',
            'role.in'                    => 'نوع المستخدم يجب أن يكون admin أو company أو user',

            //  رسائل خاصة بالشركة
            'city_id.required_if'        => 'المدينة مطلوبة في حالة التسجيل كشركة',
            'city_id.exists'             => 'المدينة غير موجودة',
            'tax_number.required_if'     => 'الرقم الضريبي مطلوب في حالة التسجيل كشركة',
            'commercial_registration.required_if' => 'السجل التجاري مطلوب في حالة التسجيل كشركة',
            'logo.required_if'           => 'شعار الشركة مطلوب في حالة التسجيل كشركة',
            'logo.image'                 => 'الملف المرفوع يجب أن يكون صورة',
            'logo.mimes'                 => 'امتداد الصورة يجب أن يكون png أو jpg أو jpeg',
            'logo.max'                   => 'حجم الصورة يجب ألا يزيد عن 2 ميجا بايت',
            'address.required_if'        => 'العنوان مطلوب في حالة التسجيل كشركة',
            'website.required_if'        => 'الموقع الإلكتروني مطلوب في حالة التسجيل كشركة',
            'website.url'                => 'يجب إدخال رابط موقع إلكتروني صالح',
            'latitude.required_if'       => 'خط العرض مطلوب في حالة التسجيل كشركة',
            'longitude.required_if'      => 'خط الطول مطلوب في حالة التسجيل كشركة',
        ];
    }
}
