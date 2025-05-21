<?php


use App\Http\Controllers\Customer\Auth\AuthController;
use App\Http\Controllers\User\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;



Route::get('/auth/social/{provider}', [SocialAuthController::class, 'socialLogin']);
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', 'me');
        Route::post('logout', 'logout');
    });
});