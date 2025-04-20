<?php

use App\Http\Controllers\Admin\Api\Auth\AuthController;
use App\Http\Controllers\Admin\Api\RoleController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::apiResource('roles', RoleController::class);
});