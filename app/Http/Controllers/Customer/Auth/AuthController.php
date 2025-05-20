<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Admin\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Auth\LoginRequest;
use App\Http\Requests\Customer\Auth\RegisterRequest;
use App\Http\Resources\Customer\Auth\CustomerResource;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseApiController
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);

        // Create Sanctum token
        $token = $user->createToken(
            'customer-api',
            expiresAt: now()->addMinutes(value: config('sanctum.expiration'))
        )->plainTextToken;

        return $this->successResponse(__('User registered successfully'), [
            'user' => CustomerResource::make($user),
            'access_token' => $token,
        ]);
    }

    public function login(LoginRequest $request)
    {
        
        // return $this->failResponse("Backend error happend");
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return $this->failResponse('Wrong credentials');
        }

        $user = auth()->user();

        // Create Sanctum token
        $token = $user->createToken(
            'customer-api',
            expiresAt: now()->addMinutes(value: config('sanctum.expiration'))
        )->plainTextToken;

        return $this->successResponse(__('Logged in successfully'), [
            'user' => CustomerResource::make($user),
            'access_token' => $token,
        ]);
    }

    public function logout()
    {
        $user = auth()->user();
        $user->currentAccessToken()->delete();
        return $this->successResponse(__('Successfully logged out'));
    }

    public function me()
    {
        // return $this->failResponse("Backend error happend");
        $user = auth()->user();
        return $this->successResponse(__('Successfully Processed'), [
            'user' => CustomerResource::make($user),
        ]);
    }
}
