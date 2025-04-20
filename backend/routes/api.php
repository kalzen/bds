<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ListingTypeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PriceHistoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PropertyAmenityController;
use App\Http\Controllers\PropertyAttributeController;
use App\Http\Controllers\PropertyCategoryController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\NewsCategoryController;
use Illuminate\Support\Facades\Route;

// PriceHistory routes
Route::get('price-history/findall', [PriceHistoryController::class, 'index']);
Route::get('price-history/findbyid/{id}', [PriceHistoryController::class, 'show']);
Route::post('price-history/save', [PriceHistoryController::class, 'store']);
Route::put('price-history/update/{id}', [PriceHistoryController::class, 'update']);
Route::delete('price-history/delete/{id}', [PriceHistoryController::class, 'destroy']);

// PropertyAmenity routes
Route::get('property-amenities/findall', [PropertyAmenityController::class, 'index']);
Route::get('property-amenities/findbyid/{property_id}/{amenity_id}', [PropertyAmenityController::class, 'show']);
Route::post('property-amenities/save', [PropertyAmenityController::class, 'store']);
Route::put('property-amenities/update/{property_id}/{amenity_id}', [PropertyAmenityController::class, 'update']);
Route::delete('property-amenities/delete/{property_id}/{amenity_id}', [PropertyAmenityController::class, 'destroy']);

// PropertyAttribute routes
Route::get('property-attributes/findall', [PropertyAttributeController::class, 'index']);
Route::get('property-attributes/findbyid/{property_id}/{attribute_id}', [PropertyAttributeController::class, 'show']);
Route::post('property-attributes/save', [PropertyAttributeController::class, 'store']);
Route::put('property-attributes/update/{property_id}/{attribute_id}', [PropertyAttributeController::class, 'update']);
Route::delete('property-attributes/delete/{property_id}/{attribute_id}', [PropertyAttributeController::class, 'destroy']);

// Basic pattern for remaining controllers:
$customRoutes = [
    'properties' => PropertyController::class,
    'projects' => ProjectController::class,
    'amenities' => AmenityController::class,
    'attributes' => AttributeController::class,
    'listing-types' => ListingTypeController::class,
    'property-categories' => PropertyCategoryController::class,
    'news' => NewsController::class,
    'news-categories' => NewsCategoryController::class,
    'locations' => LocationController::class,
    'wards' => WardController::class,
    'districts' => DistrictController::class,
    'cities' => CityController::class,
];

foreach ($customRoutes as $prefix => $controller) {
    Route::get("$prefix/findall", [$controller, 'index']);
    Route::get("$prefix/findbyid/{id}", [$controller, 'show']);
    Route::post("$prefix/save", [$controller, 'store']);
    Route::put("$prefix/update/{id}", [$controller, 'update']);
    Route::delete("$prefix/delete/{id}", [$controller, 'destroy']);
}

// Auth
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
