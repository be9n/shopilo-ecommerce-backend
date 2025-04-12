<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Middleware\CheckPermission;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('dashboard');
        })->name('dashboard');

        Route::resource('roles', RoleController::class)
        ->middleware([
            'index' => 'can:user_management.roles.view_all',
        ]);
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
