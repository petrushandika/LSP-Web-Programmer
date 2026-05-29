<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

// Artikel publik
Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
Route::post('/artikel', [ArtikelController::class, 'index'])->name('artikel.search');
Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');

// Komentar publik
Route::post('/komentar/{id_artikel}', [KomentarController::class, 'store'])->name('komentar.store');

// ── Auth Routes ────────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Admin Routes (protected) ───────────────────────────────────────────────────
Route::middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Artikel admin
    Route::post('/dashboard/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::delete('/dashboard/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
    Route::patch('/dashboard/artikel/{id}/toggle-komentar', [ArtikelController::class, 'toggleKomentar'])->name('artikel.toggleKomentar');

    // Komentar admin
    Route::delete('/dashboard/komentar/{id}', [KomentarController::class, 'destroy'])->name('komentar.destroy');
    Route::patch('/dashboard/komentar/{id}/toggle-status', [KomentarController::class, 'toggleStatus'])->name('komentar.toggleStatus');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
});
