<?php

use App\Http\Controllers\Web\SsoGoogleAuthController;
use App\Http\Controllers\Web\SsoPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
/*
|--------------------------------------------------------------------------
| Web Routes - Single Sign-On (SSO) Portal Dinas PUPR Kab. Subang
|--------------------------------------------------------------------------
*/

Route::get('/', [SsoPortalController::class, 'dashboard'])->name('sso.dashboard');
Route::get('/login', [SsoPortalController::class, 'showLogin'])->name('sso.login');
Route::post('/login', [SsoPortalController::class, 'processLogin'])->name('sso.login.post');
Route::post('/logout', [SsoPortalController::class, 'logout'])->name('sso.logout');
Route::get('/logout', [SsoPortalController::class, 'logout']); // Fallback get

// Google SSO Authentication Routes
Route::get('/auth/google', [SsoGoogleAuthController::class, 'redirect'])->name('sso.google');
Route::get('/auth/google/callback', [SsoGoogleAuthController::class, 'callback'])->name('sso.google.callback');
Route::post('/auth/google/simulate', [SsoGoogleAuthController::class, 'simulateSelectAccount'])->name('sso.google.simulate');

// OAuth2 Authorize Endpoint
Route::get('/sso/authorize', [SsoPortalController::class, 'authorizeApp'])->name('sso.authorize');

// API Documentation Page
Route::get('/docs', [SsoPortalController::class, 'documentation'])->name('sso.docs');
