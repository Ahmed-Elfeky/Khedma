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

            return ApiResponse::SendResponse(401, 'User Unauthorized', []);
        }

        if ($user->role !== 'company') {
            return ApiResponse::SendResponse(403, 'Only companies can add products.', []);
        }
        return $next($request);
    }

}
