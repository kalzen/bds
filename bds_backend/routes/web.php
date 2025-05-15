<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProvincesController;

// 🌐 Landing page
Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// 🔐 Xử lý auth
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

// 📦 Route cần đăng nhập + email xác minh
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', fn() => Inertia::render('dashboard'))->name('dashboard');

//    Route::get('/dashboard', [\App\Http\Controllers\ProjectController::class,'index'])->name('dashboard');
    Route::get('/features/management', [\App\Http\Controllers\FeaturesManagementController::class, 'index'])->name('features');



    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [\App\Http\Controllers\NewsCategoryController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\NewsCategoryController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\NewsCategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\NewsCategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\NewsCategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\NewsCategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [\App\Http\Controllers\NewsController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\NewsController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\NewsController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\NewsController::class, 'edit'])->name('edit');
        Route::post('/{id}', [\App\Http\Controllers\NewsController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\NewsController::class, 'destroy'])->name('destroy');
    });

     // Trang danh sách tất cả bất động sản
    Route::get('/projects', [\App\Http\Controllers\ProjectController::class, 'index'])->name('project.index');
    Route::post('/projects', [\App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{id}', [\App\Http\Controllers\ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [\App\Http\Controllers\ProjectController::class, 'destroy'])->name('projects.destroy');

    // Trang danh sách tất cả bất động sản
    Route::get('/properties', [\App\Http\Controllers\PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create', [\App\Http\Controllers\PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [\App\Http\Controllers\PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{id}/edit', [\App\Http\Controllers\PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{id}', [\App\Http\Controllers\PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{id}', [\App\Http\Controllers\PropertyController::class, 'destroy'])->name('properties.destroy');

    // Route để thêm, sửa, xóa amenities
    Route::post('/features/management/amenities/amenities', [\App\Http\Controllers\AmenityController::class, 'store'])->name('features.amenities.store');
    Route::put('/features/management/amenities/{amenities}', [\App\Http\Controllers\AmenityController::class, 'update'])->name('features.amenities.update');
    Route::delete('/features/management/amenities/{amenities}', [\App\Http\Controllers\AmenityController::class, 'destroy'])->name('features.amenities.destroy');

    // Route để thêm, sửa, xóa attribute
    Route::post('/features/management/attribute/attribute', [\App\Http\Controllers\AttributeController::class, 'store'])->name('features.attributes.store');
    Route::put('/features/management/attribute/{attribute}', [\App\Http\Controllers\AttributeController::class, 'update'])->name('features.attributes.update');
    Route::delete('/features/management/attribute/{attribute}', [\App\Http\Controllers\AttributeController::class, 'destroy'])->name('features.attributes.destroy');

    // Route để thêm, sửa, xóa listing_types
    Route::post('/features/management/listing_types/listing_types', [\App\Http\Controllers\ListingTypeController::class, 'store'])->name('features.listing_types.store');
    Route::put('/features/management/listing_types/{listing_types}', [\App\Http\Controllers\ListingTypeController::class, 'update'])->name('features.listing_types.update');
    Route::delete('/features/management/listing_types/{listing_types}', [\App\Http\Controllers\ListingTypeController::class, 'destroy'])->name('features.listing_types.destroy');

    // Route để thêm, sửa, xóa property_categories
    Route::post('/features/management/property_categories/property_categories', [\App\Http\Controllers\PropertyCategoryController::class, 'store'])->name('features.property_categories.store');
    Route::put('/features/management/property_categories/{property_categories}', [\App\Http\Controllers\PropertyCategoryController::class, 'update'])->name('features.property_categories.update');
    Route::delete('/features/management/property_categories/{property_categories}', [\App\Http\Controllers\PropertyCategoryController::class, 'destroy'])->name('features.property_categories.destroy');


});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

