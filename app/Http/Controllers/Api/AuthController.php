<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{



    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        return ApiResponse::SendResponse(201, 'User Created Successfully', [
            'user'  => new UserResource($user),
            'token' => $token,
        ]);
    }



    public function login(LoginRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::SendResponse(401, 'Invalid phone or password', []);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        return ApiResponse::SendResponse(
            200,
            'Login Successfully',
            (new UserResource($user))->additional(['token' => $token])
        );
    }



    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
            return ApiResponse::SendResponse(200, 'Logged out successfully', []);
        }
        return ApiResponse::SendResponse(401, 'Not authenticated', []);
    }
}
