<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Auth\LoginRequest;
use App\Http\Resources\Customer\Auth\CustomerResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // public function register(RegisterRequest $request)
    // {
    //     $validated = $request->validated();

    //     $user = User::create($validated);

    //     $token = JWTAuth::fromUser($user);
    //     $refreshToken = JWTAuth::fromUser($user); // Generate refresh token

    //     return $this->successResponse(__('User registered successfully'), [
    //         'user' => $user,
    //         'access_token' => $token,
    //         'refresh_token' => $refreshToken,
    //     ]);
    // }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->failResponse('Wrong credentials');
        }

        $user = auth()->user();
        // $refreshToken = JWTAuth::claims(['refresh' => true])
        //     ->fromUser($user); // Generate refresh token

        return $this->successResponse(__('Logged in successfully'), [
            'user' => $user,
            'access_token' => $token,
            // 'refresh_token' => $refreshToken,
            'expires_in' => config('jwt.ttl') * 60
        ]);
    }

    public function logout()
    {
        // JWTAuth::invalidate(JWTAuth::getToken());
        auth()->logout();
        return $this->successResponse(__('Successfully logged out'));
    }

    public function me()
    {
        $user = auth()->user();
        return $this->successResponse(__('Successfully Processed'), [
            'user' => CustomerResource::make($user),
        ]);
    }

    public function refresh()
    {
        try {
            $refreshToken = request()->input('refresh_token');

            if (!$refreshToken) {
                return $this->failResponse('Refresh token is required');
            }

            // Set the refresh token as the current token for JWTAuth
            $newAccessToken = JWTAuth::setToken($refreshToken)->refresh();

            $user = Auth::guard('api')->setToken($newAccessToken)->user();

            $newRefreshToken = JWTAuth::fromUser($user, ['refresh' => true]);

            return $this->successResponse(__('Token refreshed successfully'), [
                'access_token' => $newAccessToken,
                'refresh_token' => $newRefreshToken,
                // 'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        } catch (\Exception $e) {
            return $this->respondUnAuthenticated($e->getMessage());
        }
    }
}
