<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CompanyUser
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

        if ($user->role !== 'company') {
            if ($request->is('api/*')) {
                return ApiResponse::SendResponse(403, 'Only companies can add products.', []);
            }
            abort(403, 'غير مصرح لك بإضافة منتجات');
        }
        return $next($request);
    }
}
