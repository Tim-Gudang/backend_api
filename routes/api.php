<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BarangCategoryController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangStatusController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UserController;
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
    Route::get('/dashboard', function () {
        return response()->json(['message' => 'Hanya Superadmin bisa akses']);
    });

    Route::apiResource('users', UserController::class);

    Route::apiResource('roles', RoleController::class);

    Route::apiResource('gudangs', GudangController::class);

    Route::apiResource('satuans', SatuanController::class);

    Route::apiResource('barang-categories', BarangCategoryController::class);

    Route::apiResource('barang-statuses', BarangStatusController::class);

    Route::apiResource('transaction-types', TransactionTypeController::class);

    Route::apiResource('jenis-barangs', JenisBarangController::class);
    Route::patch('jenis-barang/{id}/restore', [JenisBarangController::class, 'restore']);
    Route::delete('jenis-barang/{id}/force-delete', [JenisBarangController::class, 'forceDelete']);

    //barang
    Route::apiResource('barangs', BarangController::class);
    Route::get('/barang/qrcode/save/{id}', [BarangController::class, 'generateQRCodeimage']);
    Route::get('/generate-qrcodes', [BarangController::class, 'generateAllQRCodesimage']);
    Route::get('/export-pdf', [BarangController::class, 'generateAllQRCodes']);
    Route::get('/export-pdf/{id}', [BarangController::class, 'generateQRCodeById']);
});

Route::post('/toggle-permission', [PermissionController::class, 'togglePermission'])
    ->middleware(['auth:api', 'role_or_permission:superadmin|manage_permissions']);

//memastikan cek role login
Route::middleware(['auth:api'])->get('/check-roles', [UserController::class, 'checkRoles']);
