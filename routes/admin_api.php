<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::apiResource('roles', RoleController::class);

    Route::apiResource('products', ProductController::class);

    Route::get('categories/list', [CategoryController::class, 'list']);
    Route::apiResource('categories', CategoryController::class);

    Route::get('permissions/list', [PermissionController::class, 'permissionsList']);

    Route::delete('files/{media}', [FileController::class, 'destroy']);
});