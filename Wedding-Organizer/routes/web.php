<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingController;

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

Route::get('/', function () {
    return view('welcome');
});

// Web Resource routes for view rendering (HTML responses)
Route::resource('users', UserController::class);
Route::resource('catalogues', CatalogueController::class);
Route::resource('orders', OrderController::class);
Route::resource('settings', SettingController::class);
