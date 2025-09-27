<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return view('welcome');
});

// Resource routes for CRUD operations
Route::resource('users', UserController::class);
Route::resource('catalogues', CatalogueController::class);
Route::resource('orders', OrderController::class);
Route::resource('settings', SettingController::class);
