<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminUser
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($request->is('api/*') && !$user) {
            return ApiResponse::SendResponse(401, 'Unauthorized API call', []);
        }

        if ($request->is('api/*') && $user->role !== 'admin') {
            return ApiResponse::SendResponse(403, 'Access denied. Only admins allowed.', []);
        }

        if (!$request->is('api/*') && !$user) {
            return redirect()->route('admin.login')->with('error', 'يجب تسجيل الدخول أولاً');
        }
        return $next($request);
    }
}
