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

    Route::apiResource('users', UserController::class);
      //role
    Route::apiResource('roles', RoleController::class);
    //barang
    Route::apiResource('barangs',BarangController::class);
    Route::get('/barang/qrcode/save/{id}', [BarangController::class, 'generateQRCodeimage']);
    Route::get('/generate-qrcodes', [BarangController::class, 'generateAllQRCodesimage']);
    Route::get('/scan-qrcode', [BarangController::class, 'processScannedQr']);
    Route::get('/generate/{id}', [BarangController::class, 'generateQRCodeById']);
});

Route::post('/toggle-permission', [PermissionController::class, 'togglePermission'])
->middleware(['auth:api', 'role_or_permission:superadmin|manage_permissions']);

//memastikan cek role login
Route::middleware(['auth:api'])->get('/check-roles', [UserController::class, 'checkRoles']);



