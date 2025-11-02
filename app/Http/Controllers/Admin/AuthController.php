<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->validated();

        // محاولة تسجيل الدخول كمشرف
        if (Auth::attempt($credentials)) {
            // التحقق أن المستخدم Admin فقط
            if (Auth::user()->role == 'admin') {
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'غير مصرح لك بالدخول للوحة التحكم.']);
        }

        return back()->withErrors(['email' => 'بيانات تسجيل الدخول غير صحيحة.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
