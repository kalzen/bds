<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CityController;

// 🌐 Landing page
Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// 🔐 Xử lý auth
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

// 📦 Route cần đăng nhập + email xác minh
Route::middleware(['auth', 'verified'])->group(function () {

//    Route::get('/dashboard' )->name('dashboard');
    Route::get('/location', [\App\Http\Controllers\LocationController::class, 'index'])->name('location');


    // Các action riêng cho District ngay trên location
    Route::post('/location/districts', [\App\Http\Controllers\DistrictController::class, 'store'])->name('location.districts.store');
    Route::put('/location/districts/{district}', [\App\Http\Controllers\DistrictController::class, 'update'])->name('location.districts.update');
    Route::delete('/location/districts/{district}', [\App\Http\Controllers\DistrictController::class, 'destroy'])->name('location.districts.destroy');

    Route::post('/location/cities', [\App\Http\Controllers\CityController::class, 'store'])->name('location.cities.store');
    Route::put('/location/cities/{city}', [\App\Http\Controllers\CityController::class, 'update'])->name('location.cities.update');
    Route::delete('/location/cities/{city}', [\App\Http\Controllers\CityController::class, 'destroy'])->name('location.cities.destroy');

    // Route để thêm, sửa, xóa Ward
    Route::post('/location/wards', [\App\Http\Controllers\WardController::class, 'store'])->name('location.wards.store');
    Route::put('/location/wards/{ward}', [\App\Http\Controllers\WardController::class, 'update'])->name('location.wards.update');
    Route::delete('/location/wards/{ward}', [\App\Http\Controllers\WardController::class, 'destroy'])->name('location.wards.destroy');


});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
