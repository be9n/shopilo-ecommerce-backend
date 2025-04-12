<?php

use App\Http\Controllers\Api\RolePermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hello', function () {

    return "hello";
});

// Role and Permission API routes
// Roles
Route::get('/roles', [RolePermissionController::class, 'getRoles'])
->name('api.roles.index');

// Permissions
Route::get('/permissions', [RolePermissionController::class, 'getPermissions'])
    ->name('api.permissions.index');

// Get permissions organized by sections
Route::get('/permissions/sectioned', [RolePermissionController::class, 'getSectionedPermissions'])
    ->name('api.permissions.sectioned');

// User roles and permissions
Route::get('/users/{user}/roles', [RolePermissionController::class, 'getUserRolesAndPermissions'])
    ->name('api.users.roles.show');

// Get only permission names
Route::get('/users/{user}/permissions', [RolePermissionController::class, 'getUserPermissionNames'])
    ->name('api.users.permissions.show');

// Get grouped permissions
Route::get('/users/{user}/permissions/grouped', [RolePermissionController::class, 'getUserGroupedPermissions'])
    ->name('api.users.permissions.grouped');

// Get user permissions organized by sections
Route::get('/users/{user}/permissions/sectioned', [RolePermissionController::class, 'getUserSectionedPermissions'])
    ->name('api.users.permissions.sectioned');

Route::put('/users/{user}/roles', [RolePermissionController::class, 'updateUserRoles'])
    ->name('api.users.roles.update');