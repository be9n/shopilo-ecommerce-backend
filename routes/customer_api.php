<?php


use App\Events\MessageSent;
use App\Events\MessageSent2;
use App\Http\Controllers\Customer\Auth\AuthController;
use App\Http\Controllers\Customer\Auth\SocialAuthController;
use App\Http\Controllers\Customer\HomePageController;
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

Route::get('/home_page', HomePageController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/broadcast-test', function (Request $request) {
        $message = $request->message ?? 'Hello from Reverb 1!';
        event(new MessageSent(auth()->user(), $message));

        return response()->json(['success' => true, 'message' => 'Event broadcasted']);
    });

    Route::post('/broadcast-test2', function (Request $request) {
        $message = $request->message ?? 'Hello from Reverb 2!';
        event(new MessageSent2($message));

        return response()->json(['success' => true, 'message' => 'Event broadcasted']);
    });
});