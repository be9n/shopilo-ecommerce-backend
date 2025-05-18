<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\BaseApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Api\Admin\Auth\UserResourceWithPermissions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends BaseApiController
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);

        $token = JWTAuth::fromUser($user);
        // $refreshToken = JWTAuth::fromUser($user); // Generate refresh token

        return $this->successResponse('User registered successfully', [
            'user' => $user,
            'access_token' => $token,
            // 'refresh_token' => $refreshToken,
            // 'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->failResponse('Wrong credentials');
        }

        $user = auth()->user();
        // $refreshToken = JWTAuth::claims(['refresh' => true])
        //     ->fromUser($user); // Generate refresh token

        return $this->successResponse('Logged in successfully', [
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
        return $this->successResponse('Successfully logged out');
    }

    public function me()
    {
        $user = auth()->user();
        return $this->successResponse("Successfully Processed", [
            'user' => UserResourceWithPermissions::make($user->load('roles.permissions')),
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

            return $this->successResponse('Token refreshed successfully', [
                'access_token' => $newAccessToken,
                'refresh_token' => $newRefreshToken,
                // 'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        } catch (\Exception $e) {
            return $this->respondUnAuthenticated($e->getMessage());
        }
    }
}
