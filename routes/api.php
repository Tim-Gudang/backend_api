<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// prefix untuk auth
Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('auth.login');
    });
// untuk logout dan cek user info
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'userInfo'])->name('auth.user');
    });
});

// untuk role super admin
Route::middleware(['auth:api'])->group(function () {
    //user
    Route::middleware(['permission:view_user'])->get('/users', [UserController::class, 'index']);
    Route::middleware(['permission:create_user'])->post('/users', [UserController::class, 'store']);
    Route::middleware(['permission:update_user'])->get('/users/{id}', [UserController::class, 'show']);
    Route::middleware(['permission:view_user'])->put('/users/{id}', [UserController::class, 'update']);
    Route::middleware(['permission:delete_user'])->delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/check-roles', [UserController::class, 'checkRoles']);
      //role
    Route::middleware(['permission:create_role'])->post('/roles', [RoleController::class, 'createRole']);
    Route::middleware(['permission:view_role'])->get('/roles', [RoleController::class, 'index']);
    Route::middleware(['permission:view_role'])->get('/roles/{id}', [RoleController::class, 'show']);
    Route::middleware(['permission:update_role'])->put('/roles/{id}', [RoleController::class, 'update']);
    Route::middleware(['permission:delete_role'])->delete('/roles/{id}', [RoleController::class, 'destroy']);
    //cek role saja kalau itu admin
    Route::get('/dashboard', function(){
        return response()->json(['message' => 'Hanya Superadmin bisa akses']);
    });
    Route::post('/barang', [BarangController::class, 'store']);

});

//memastikan cek role login
Route::middleware(['auth:api'])->get('/check-roles', [UserController::class, 'checkRoles']);

Route::middleware(['auth:api', 'role:superadmin'])->get('/dashboard', function () {
});

Route::post('/toggle-permission', [PermissionController::class, 'togglePermission'])
    ->middleware(['auth:api', 'role_or_permission:superadmin|manage_permissions']);




