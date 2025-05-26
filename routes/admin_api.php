<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;

Route::macro('extendedApiResource', function ($name, $controller) {
    Route::post("{$name}/{id}/change_active", [$controller, 'changeActive'])->name("{$name}.change_active");
    return Route::apiResource($name, $controller);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::apiResource('roles', RoleController::class);

    Route::post('products/{id}/change_active', [ProductController::class, 'changeActive']);
    Route::extendedApiResource('products', ProductController::class);

    Route::get('categories/list', [CategoryController::class, 'list']);
    Route::extendedApiResource('categories', CategoryController::class);

    Route::get('permissions/list', [PermissionController::class, 'permissionsList']);

    Route::delete('files/{media}', [FileController::class, 'destroy']);

    Route::apiResource('discounts', DiscountController::class);
});