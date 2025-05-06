<?php

use App\Http\Controllers\Admin\Api\Auth\AuthController;
use App\Http\Controllers\Admin\Api\CategoryController;
use App\Http\Controllers\Admin\Api\PermissionController;
use App\Http\Controllers\Admin\Api\ProductController;
use App\Http\Controllers\Admin\Api\RoleController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::controller(RoleController::class)->group(function () {
        Route::get('roles', 'index')->middleware('permission:user_management.roles.view_all');
        Route::get('roles/{role}', 'show')->middleware('permission:user_management.roles.view');
        Route::post('roles', 'store')->middleware('permission:user_management.roles.create');
        Route::put('roles/{role}', 'update')->middleware('permission:user_management.roles.edit');
        Route::delete('roles/{role}', 'destroy')->middleware('permission:user_management.roles.delete');
    });

    Route::apiResource('products', ProductController::class);

    Route::get('categories_list', [CategoryController::class, 'categoriesList']);
    Route::get('permissions_list', [PermissionController::class, 'permissionsList']);
});