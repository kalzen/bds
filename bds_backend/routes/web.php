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

    // 📊 Trang dashboard chính → danh sách thành phố
//    Route::get('/dashboard' )->name('dashboard');
    Route::get('/location', [CityController::class, 'index'])->name('location');

    // 🏙️ CRUD Thành phố
    Route::resource('cities', CityController::class);
    // Note: index đã dùng cho /dashboard
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
