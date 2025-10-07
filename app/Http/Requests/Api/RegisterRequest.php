<?php

namespace App\Http\Requests\Api;


use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;



class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }



    // validation api response //
    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $response =  ApiResponse::SendResponse(422, ' validation errors',  $validator->messages()->all());
            throw new ValidationException($validator, $response);
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',

            // بيانات الشركة (لو user_type = company)
            'address' => 'nullable|string',
            'city_id' => 'nullable|exists:cities,id',
            'website' => 'nullable|string',
            'commercial_registration' => 'nullable|string',
            'tax_number' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',

            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'الاسم مطلوب',
            'phone.required'     => 'رقم الهاتف مطلوب',
            'phone.unique'       => 'رقم الهاتف مسجل بالفعل',
            'password.required'  => 'كلمة المرور مطلوبة',
            'password.min'       => 'كلمة المرور يجب ألا تقل عن 6 أحرف',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'logo.image'         => 'الملف المرفوع يجب أن يكون صورة',
            'logo.mimes'         => 'امتداد الصورة يجب أن يكون png أو jpg أو jpeg',
            'logo.max'           => 'حجم الصورة يجب ألا يزيد عن 2 ميجا بايت',
        ];
    }
}
