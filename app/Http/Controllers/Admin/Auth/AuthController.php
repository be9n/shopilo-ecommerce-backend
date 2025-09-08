<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Admin\BaseApiController;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\Admin\Auth\AdminWithPermissionsResource;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends BaseApiController
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->failResponse('Wrong credentials');
        }

        $user = auth()->user();
        if ($user->user_type !== UserTypeEnum::ADMIN) {
            auth()->logout();
            return $this->failResponse('Wrong credentials');
        }

        return $this->successResponse(__('Logged in successfully'), [
            'user' => $user,
            'access_token' => $token,
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return $this->successResponse(__('Successfully logged out'));
    }

    public function me()
    {
        $user = auth()->user();
        return $this->successResponse(__('Successfully Processed'), [
            'user' => AdminWithPermissionsResource::make($user->load('roles.permissions')),
        ]);
    }
}
