<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CityController;

// 🌐 Trang landing (khách truy cập vào '/')
Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// 🔐 Xử lý đăng nhập
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

// 📝 Xử lý đăng ký
Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

// 📦 Các route yêu cầu đăng nhập & xác minh email
Route::middleware(['auth', 'verified'])->group(function () {

    // 📊 Dashboard chính
    Route::get('/dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // 🏙️ CRUD Thành phố (City)
    Route::resource('cities', CityController::class);
    // - GET     /cities            → cities.index    (Danh sách)
    // - GET     /cities/create     → cities.create   (Form tạo mới)
    // - POST    /cities            → cities.store    (Lưu thành phố)
    // - GET     /cities/{id}/edit  → cities.edit     (Form chỉnh sửa)
    // - PUT     /cities/{id}       → cities.update   (Cập nhật)
    // - DELETE  /cities/{id}       → cities.destroy  (Xoá thành phố)
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
