<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

use App\Http\Controllers\SinhVienController;

Route::get('sinhviens', [SinhVienController::class, 'index']);
Route::get('sinhviens/{id}', [SinhVienController::class, 'show']);
Route::post('sinhviens', [SinhVienController::class, 'store']);
Route::put('sinhviens/{id}', [SinhVienController::class, 'update']);
Route::delete('sinhviens/{id}', [SinhVienController::class, 'destroy']);
