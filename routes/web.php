<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\Frontend\BarangController as FrontendBarangController;
use App\Http\Controllers\Frontend\DashboardController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/scan-result', function (Request $request) {
    $data = $request->query('data');
    return view('scan-result', compact('data'));
});


Route::get('/login',function () {
    return view('auth.login');
})->name('login');

route::get('/user_profile', function () {
    return view('profile.user_profile');

})->name('user_profile');

route::get('/user_profile', function () {
    return view('profile.user_profile');
})->name('user_profile');

    Route::resource('barangs', FrontendBarangController::class);

