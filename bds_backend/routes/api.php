<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AmenityController,
    AttributeController,
    AuthController,
    CityController,
    DistrictController,
    ListingTypeController,
    LocationController,
    NewsController,
    NewsCategoryController,
    PriceHistoryController,
    ProjectController,
    PropertyAmenityController,
    PropertyAttributeController,
    PropertyCategoryController,
    PropertyController,
    WardController
};

// API Resources
Route::apiResource('cities', CityController::class);
Route::apiResource('districts', DistrictController::class);
Route::apiResource('wards', WardController::class);
Route::apiResource('locations', LocationController::class);
Route::apiResource('news-categories', NewsCategoryController::class);
Route::apiResource('news', NewsController::class);
Route::apiResource('property-categories', PropertyCategoryController::class);
Route::apiResource('listing-types', ListingTypeController::class);
Route::apiResource('attributes', AttributeController::class);
Route::apiResource('amenities', AmenityController::class);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('properties', PropertyController::class);
Route::apiResource('price-history', PriceHistoryController::class);

// Special case: composite key (needs custom routes)
Route::get('property-amenities', [PropertyAmenityController::class, 'index']);
Route::get('property-amenities/{property_id}/{amenity_id}', [PropertyAmenityController::class, 'show']);
Route::post('property-amenities', [PropertyAmenityController::class, 'store']);
Route::put('property-amenities/{property_id}/{amenity_id}', [PropertyAmenityController::class, 'update']);
Route::delete('property-amenities/{property_id}/{amenity_id}', [PropertyAmenityController::class, 'destroy']);

Route::get('property-attributes', [PropertyAttributeController::class, 'index']);
Route::get('property-attributes/{property_id}/{attribute_id}', [PropertyAttributeController::class, 'show']);
Route::post('property-attributes', [PropertyAttributeController::class, 'store']);
Route::put('property-attributes/{property_id}/{attribute_id}', [PropertyAttributeController::class, 'update']);
Route::delete('property-attributes/{property_id}/{attribute_id}', [PropertyAttributeController::class, 'destroy']);

// Auth routes
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
