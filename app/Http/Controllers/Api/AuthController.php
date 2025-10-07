<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\ApiResponse;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\VerifyOtpRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function register(RegisterRequest $request)
{
    $user = User::create([
        'name'     => $request->name,
        'phone'    => $request->phone,
        'password' => bcrypt($request->password),
    ]);

    $otp = rand(1000, 9999);

    $user->update([
        'otp_code' => $otp,
        'otp_expires_at' => Carbon::now()->addMinutes(5),
    ]);


    return ApiResponse::SendResponse(200, 'OTP sent successfully. Please verify to complete registration.', [
        'phone' => $user->phone,
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
        if($user){
            $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
           ]);
          return ApiResponse::SendResponse(200, 'OTP sent successfully', []);
        }else{
           return ApiResponse::SendResponse(404, 'User Not Found', []);

        }

    }

 public function verifyOtp(VerifyOtpRequest $request)
{
    $user = User::where('phone', $request->phone)->first();

    // 1️⃣ لو مفيش مستخدم بالرقم ده
    if (!$user) {
        return ApiResponse::SendResponse(404, 'User not found.', [
            'is_verified' => false
        ]);
    }
    // 2️⃣ لو المستخدم عمره ما اتبعت له OTP
    if (is_null($user->otp_code) || is_null(!$user->otp_expires_at)) {
        return ApiResponse::SendResponse(400, 'No OTP was sent to this number. Please request a new code.', [
            'is_verified' => false
        ]);
    }

    // 3️⃣ لو الكود انتهت صلاحيته
    if ($user->otp_expires_at < now()) {
       
        return ApiResponse::SendResponse(400, 'OTP has expired. Please request a new one.', [
            'is_verified' => false
        ]);
    }

    // 4️⃣ لو الكود غلط
    if ($user->otp_code !== $request->otp_code) {
        return ApiResponse::SendResponse(400, 'Incorrect OTP code.', [
            'is_verified' => false
        ]);
    }

    // ✅ 5️⃣ الكود صحيح → نتحقق وننظف القيم
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
