<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\PasswordChangeRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\ResetPassRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Requests\VerifyOtpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);

        // رفع الصورة لو موجودة
        if ($request->hasFile('logo')) {
            $extension = $request->logo->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $request->logo->move(public_path('uploads/users'), $filename);
            $data['logo'] = 'uploads/users/' . $filename;
        }

        $user = User::create($data);
        $otp = rand(1000, 9999);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        return ApiResponse::SendResponse(200, 'OTP sent successfully. Please verify to complete registration.', [
            'phone' => $user->phone,
            'otp_code'   => $user->otp_code,
            'is_verified' => false
        ]);
    }
    //............... opt code start ................//
    public function login(LoginRequest $request)
    {
        // التحقق من رقم الهاتف والباسورد
        if (!Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            return ApiResponse::SendResponse(401, 'Invalid phone or password', []);
        }

        $user = Auth::user();
        // لو المستخدم لسه ما فعّلش رقم الموبايل
        if (!$user->is_verified) {
            return ApiResponse::SendResponse(403, 'Please verify your phone number first.', [
                'phone' => $user->phone,
                'is_verified' => false,
            ]);
        }

        // في حالة التحقق من رقم الموبايل بنجاح
        if ($user->is_verified) {

            $token = $user->createToken('myapptoken')->plainTextToken;
            return ApiResponse::SendResponse(200, 'Login successful', [
                'user' => new UserResource($user),
                'token' => $token,
                'phone' => $user->phone,
                'is_verified' => true,
            ]);
        }
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
        ]);
        if ($validator->fails()) {
            return ApiResponse::SendResponse(400, ' the phone not valid', []);
        }
        $otp = rand(1000, 9999);
        $user = User::where(['phone' => $request->phone])->first();
        if ($user) {
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(5),
            ]);
            return ApiResponse::SendResponse(200, 'OTP sent successfully', []);
        } else {
            return ApiResponse::SendResponse(404, 'User Not Found', []);
        }
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        // لو مفيش مستخدم بالرقم ده
        if (!$user) {
            return ApiResponse::SendResponse(404, 'User not found.', [
                'is_verified' => false
            ]);
        }
        //  لو المستخدم عمره ما اتبعت له OTP
        if (is_null($user->otp_code) || is_null(!$user->otp_expires_at)) {
            return ApiResponse::SendResponse(400, 'No OTP was sent to this number. Please request a new code.', [
                'is_verified' => false
            ]);
        }

        //  لو الكود انتهت صلاحيته
        if ($user->otp_expires_at < now()) {

            return ApiResponse::SendResponse(400, 'OTP has expired. Please request a new one.', [
                'is_verified' => false
            ]);
        }

        //  لو الكود غلط
        if ($user->otp_code !== $request->otp_code) {
            return ApiResponse::SendResponse(400, 'Incorrect OTP code.', [
                'is_verified' => false
            ]);
        }

        // الكود صحيح → نتحقق وننظف القيم
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
            'phone_verified_at' => now(),
            'is_verified' => true
        ]);

        // إنشاء التوكن (تسجيل دخول تلقائي)
        $token = $user->createToken('API Token')->plainTextToken;

        return ApiResponse::SendResponse(200, 'Phone verified successfully.', [
            'id' => $user->id,
            'phone' => $user->phone,
            'is_verified' => true,
            'token' => $token,
        ]);
    }

    //............... opt code end ................//

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $phoneChanged = false;

        // 🔸 لو غيّر رقم الهاتف، نحضر OTP جديد
        if ($request->filled('phone') && $request->phone !== $user->phone) {
            $phoneChanged = true;
            $otp = rand(1000, 9999);
            $data['otp_code'] = $otp;
            $data['otp_expires_at'] = now()->addMinutes(5);
            $data['is_verified'] = false; // لو عندك عمود التحقق
        }
        // تحديث كلمة المرور إن وُجدت
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('logo')) {
            $extension = $request->logo->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $request->logo->move(public_path('uploads/users'), $filename);
            $data['logo'] = 'uploads/users/' . $filename;
        }
        $user->update($data);
        // لو تم تغيير رقم الهاتف → نرسل OTP
        if ($phoneChanged) {
            // هنا تقدر تبعت SMS أو تحفظه مبدئيًا فقط
            return ApiResponse::SendResponse(200, 'تم تحديث الملف بنجاح، يرجى إدخال كود التحقق المرسل إلى رقمك الجديد.', [
                'phone' => $user->phone,
                'otp_code' => $data['otp_code'], //  (للتجربة فقط، لا تُظهره في الإنتاج)
                'is_verified' => false,
            ]);
        }

        return ApiResponse::SendResponse(200, 'تم تحديث الملف الشخصي بنجاح', [
            'user' => $user,
        ]);
    }

    // إعادة تعيين كلمة المرور
    public function resetPassword(ResetPassRequest $request)
    {
        $data = $request->validated();
        // البحث عن المستخدم
        $user = User::where('phone', $data['phone'])->first();
        // لو المستخدم مش موجود
        if (!$user) {
            return ApiResponse::SendResponse(404, 'المستخدم غير موجود.', []);
        }
        // التأكد إن الكود تم التحقق منه مسبقًا
        if (!$user->otp_verified) {
            return ApiResponse::SendResponse(400, 'يجب التحقق من الرمز أولاً.', []);
        }
        // تحديث كلمة المرور وإلغاء بيانات الـ OTP
        $user->update([
            'password' => Hash::make($data['password']),
            'otp_code' => null,
            'otp_verified' => false,
            'otp_expires_at' => null,
        ]);

        return ApiResponse::SendResponse(200, 'تمت إعادة تعيين كلمة المرور بنجاح.', []);
    }

    public function ChangePassword(PasswordChangeRequest $request)
    {
        $user = Auth::user();
        // التحقق من كلمة المرور القديمة
        if (!Hash::check($request->old_password, $user->password)) {
            return ApiResponse::SendResponse(400, 'كلمة المرور القديمة غير صحيحة.', []);
        }
        // تحديث كلمة المرور الجديدة
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return ApiResponse::SendResponse(200, 'تم تغيير كلمة المرور بنجاح.', []);
    }

    // logout //
    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
            return ApiResponse::SendResponse(200, 'Logged out successfully', []);
        }
        return ApiResponse::SendResponse(401, 'Not authenticated', []);
    }
}
