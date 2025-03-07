<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// prefix untuk auth
Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register')->name('auth.register');
        Route::post('login', 'login')->name('auth.login');
    });
// untuk logout dan cek user info
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'userInfo'])->name('auth.user');
    });
});

// untuk role super admin
Route::middleware(['auth:api', 'role:superadmin'])->group(function () {
    Route::post('/roles', [RoleController::class, 'createRole']);
    Route::post('/users', [UserController::class, 'store']);
    //cek role saja kalau itu admin
    Route::get('/dashboard', function(){
        return response()->json(['message' => 'Hanya Superadmin bisa akses']);
    });
});


//memastikan cek role login
Route::middleware(['auth:api'])->get('/check-roles', [UserController::class, 'checkRoles']);

Route::middleware(['auth:api', 'role:superadmin'])->get('/dashboard', function () {
});

Route::post('/toggle-permission', [PermissionController::class, 'togglePermission'])
    ->middleware(['auth:api', 'permission:manage_permissions','role:superadmin']);




