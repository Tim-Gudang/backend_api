<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register')->name('auth.register');
        Route::post('login', 'login')->name('auth.login');
        Route::post('logout', 'logOut')->name('auth.logout');
    });

    Route::middleware('auth:api')->controller(AuthController::class)->group(function () {
        Route::get('user', 'userInfo')->name('auth.user');
    });
});
