<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CityController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');
Route::get('/city', [\App\Http\Controllers\WelcomeController::class, 'index']);
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
