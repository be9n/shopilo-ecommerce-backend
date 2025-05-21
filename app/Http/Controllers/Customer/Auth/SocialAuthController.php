<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Admin\BaseApiController;
use App\Http\Resources\Customer\Auth\CustomerResource;
use App\Models\User;
use App\Enums\UserTypeEnum;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends BaseApiController
{
    public function socialLogin(Request $request, $provider)
    {
        try {
            $token = $request->token;
            $socialUser = Socialite::driver($provider)->stateless()->userFromToken($token);

            $existingUser = User::where('email', $socialUser->getEmail())->first();

            if ($existingUser) {
                // Scenario: User exists, but checking if they're already connected to another provider
                if ($existingUser->provider !== null && $existingUser->provider_id !== null && $existingUser->provider !== $provider) {
                    throw new Exception('This email is used in another account');
                }

                $user = $existingUser;
            } else {
                // Scenario: New user, create account
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'user_type' => UserTypeEnum::CUSTOMER,
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);
            }

            $token = $user->createToken('customer-token')->plainTextToken;

            return $this->successResponse(__('Logged in successfully'), [
                'user' => CustomerResource::make($user),
                'access_token' => $token,
            ]);

        } catch (Exception $e) {
            return $this->failResponse($e->getMessage());
        }
    }
}
