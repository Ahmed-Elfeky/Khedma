<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return ApiResponse::SendResponse(401, 'User Unauthorized', []);
        }
        if ($user->role !== 'admin') {
            return ApiResponse::SendResponse(403, 'Access denied. Only admins allowed.', []);
        }
        return $next($request);
    }
}
