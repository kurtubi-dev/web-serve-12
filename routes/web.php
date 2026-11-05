<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Single Sign-On (SSO) Kampus Politeknik
|--------------------------------------------------------------------------
*/

// Root redirect
Route::get('/', function () {
    return Auth::check() ? redirect()->route('portal') : redirect()->route('login');
})->name('home');

// Gerbang Autentikasi SSO (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::get('/auth/mock-login', [AuthController::class, 'mockLogin'])->name('auth.mock');
});

// Single Sign-Out (Auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Seluruh Layanan Kampus Terintegrasi SSO (Harus Terautentikasi)
Route::middleware('auth')->group(function () {
    // Portal Launchpad Utama
    Route::get('/portal', [PortalController::class, 'index'])->name('portal');

    // Modul Lintas Layanan
    Route::prefix('layanan')->name('services.')->group(function () {
        Route::get('/akademik', [PortalController::class, 'akademik'])->name('akademik');
        Route::get('/elearning', [PortalController::class, 'elearning'])->name('elearning');
        Route::get('/perpustakaan', [PortalController::class, 'perpustakaan'])->name('perpustakaan');
    });
});
