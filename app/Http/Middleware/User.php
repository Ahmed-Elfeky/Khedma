<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class User
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            if ($request->is('api/*')) {
                return ApiResponse::SendResponse(401, 'User Unauthorized', []);
            }
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }
        if ($user->role !== 'user') {
            if ($request->is('api/*')) {
                return ApiResponse::SendResponse(403, 'Only normal users can access this route.', []);
            }
            abort(403, 'غير مصرح لك بالدخول إلى هذه الصفحة');
        }
        return $next($request);
    }
}
