<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ApiResponse;

class RolePermissionMiddleware
{
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $request->is('api/*')
                ? ApiResponse::SendResponse(401, 'User Unauthorized', [])
                : redirect()->route('admin.login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // لو المستخدم مش عنده أي من الصلاحيات المطلوبة
        foreach ($permissions as $permission) {
            if ($user->hasPermission($permission)) {
                return $next($request);
            }
        }

        return $request->is('api/*')
            ? ApiResponse::SendResponse(403, 'Access denied. You don\'t have permission.', [])
            : abort(403, 'غير مصرح لك بالدخول');
    }
}
