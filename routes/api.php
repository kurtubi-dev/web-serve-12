<?php

use App\Http\Controllers\Api\ClientAppController;
use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\SsoAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
/*
|--------------------------------------------------------------------------
| API Routes - Web Service SSO Dinas PUPR Kabupaten Subang
|--------------------------------------------------------------------------
*/

Route::prefix('v1/sso')->group(function () {
    // 1. Autentikasi Publik SSO
    Route::post('/login', [SsoAuthController::class, 'login']);
    Route::post('/token', [SsoAuthController::class, 'exchangeToken']);
    Route::post('/verify-token', [SsoAuthController::class, 'verifyToken']);
    Route::post('/validate-client', [SsoAuthController::class, 'validateClient']);

    // 2. Layanan Informasi Publik / Metadata Klien
    Route::get('/clients', [ClientAppController::class, 'index']);
    Route::get('/bidang-list', [PegawaiController::class, 'listBidang']);

    // 3. Endpoint Terproteksi Token (Bearer Token / Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [SsoAuthController::class, 'me']);
        Route::get('/userinfo', [SsoAuthController::class, 'me']);
        Route::post('/logout', [SsoAuthController::class, 'logout']);

        // Data Kepegawaian untuk Integrasi Lintas Aplikasi
        Route::get('/pegawai', [PegawaiController::class, 'index']);
        Route::get('/pegawai/{nip}', [PegawaiController::class, 'show']);

        // Manajemen Client App (Khusus Superadmin/Admin IT)
        Route::post('/clients', [ClientAppController::class, 'store']);
    });
});
