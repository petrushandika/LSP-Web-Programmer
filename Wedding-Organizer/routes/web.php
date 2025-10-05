<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
| These routes return views (HTML pages) for the web interface.
| For API endpoints that return JSON, use routes/api.php instead.
|
*/

// Landing page routes
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication routes (only for guests)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout route (for authenticated users)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Catalogue detail route (before resource routes to avoid conflicts)
Route::get('/catalogue/{id}', [LandingController::class, 'catalogueDetail'])->name('catalogue.detail');

// Web Resource routes for view rendering (HTML responses)
Route::resource('users', UserController::class);
Route::resource('catalogues', CatalogueController::class);
Route::resource('orders', OrderController::class);
Route::resource('settings', SettingController::class);

// Admin routes (only for admin users)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard.index');
    Route::get('/catalogues', [AdminController::class, 'catalogues'])->name('admin.catalogues');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    
    // API routes for admin functionality
    Route::prefix('api')->group(function () {
        // Catalogue API routes
        Route::get('/catalogues', [AdminController::class, 'apiCatalogues'])->name('admin.api.catalogues');
        Route::post('/catalogues', [AdminController::class, 'apiStoreCatalogue'])->name('admin.api.catalogues.store');
        Route::put('/catalogues/{id}', [AdminController::class, 'apiUpdateCatalogue'])->name('admin.api.catalogues.update');
        Route::delete('/catalogues/{id}', [AdminController::class, 'apiDeleteCatalogue'])->name('admin.api.catalogues.delete');
        
        // Order API routes
        Route::get('/orders', [AdminController::class, 'apiOrders'])->name('admin.api.orders');
        Route::get('/orders/{id}', [AdminController::class, 'apiGetOrder'])->name('admin.api.orders.show');
        Route::put('/orders/{id}/status', [AdminController::class, 'apiUpdateOrderStatus'])->name('admin.api.orders.status');
    });
});
