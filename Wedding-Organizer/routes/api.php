<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\CatalogueApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\SettingApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Resource routes for JSON responses
Route::prefix('v1')->group(function () {
    // User API endpoints
    Route::apiResource('users', UserApiController::class);
    
    // Catalogue API endpoints
    Route::apiResource('catalogues', CatalogueApiController::class);
    
    // Order API endpoints
    Route::apiResource('orders', OrderApiController::class);
    
    // Setting API endpoints
    Route::apiResource('settings', SettingApiController::class);
});

// Alternative routes without version prefix (for backward compatibility)
Route::apiResource('users', UserApiController::class);
Route::apiResource('catalogues', CatalogueApiController::class);
Route::apiResource('orders', OrderApiController::class);
Route::apiResource('settings', SettingApiController::class);
