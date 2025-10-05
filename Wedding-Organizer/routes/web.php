<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;

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

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Web Resource routes for view rendering (HTML responses)
Route::resource('users', UserController::class);
Route::resource('catalogues', CatalogueController::class);
Route::resource('orders', OrderController::class);
Route::resource('settings', SettingController::class);

// Catalogue detail route (after resource routes to avoid conflicts)
Route::get('/catalogue-detail/{id}', [LandingController::class, 'catalogueDetail'])->name('catalogue.detail');
