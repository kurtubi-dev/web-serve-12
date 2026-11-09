<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SsoAuditLog;
use App\Models\SsoAuthCode;
use App\Models\SsoClient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class SsoAuthController extends Controller
{
    /**
     * Endpoint: POST /api/v1/sso/login
     * Login langsung via API menggunakan NIP atau Email + Password
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string', // NIP atau Email
            'password' => 'required|string',
            'client_id' => 'nullable|string|exists:sso_clients,client_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $identifier = $request->input('identifier');
        $user = User::where('email', $identifier)
            ->orWhere('nip', $identifier)
            ->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            SsoAuditLog::record(
                userId: $user?->id,
                action: 'FAILED_LOGIN',
                clientId: $request->input('client_id'),
                request: $request,
                details: ['identifier' => $identifier, 'reason' => 'Invalid credentials']
            );

            return response()->json([
                'status' => 'error',
                'message' => 'NIP/Email atau password salah',
            ], 401);
        }

        if (! $user->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun pegawai ini sedang dinonaktifkan. Silakan hubungi Administrator IT Dinas PUPR Subang.',
            ], 403);
        }

        // Update waktu login terakhir
        $user->update(['last_login_at' => Carbon::now()]);

        // Cek client jika ada
        $clientName = 'PUPR Subang Central';
        if ($request->filled('client_id')) {
            $client = SsoClient::where('client_id', $request->input('client_id'))->first();
            if ($client) {
                $clientName = $client->name;
            }
        }

        // Buat access token Sanctum
        $token = $user->createToken('sso_token_' . $clientName, ['*'], now()->addDays(7))->plainTextToken;

        SsoAuditLog::record(
            userId: $user->id,
            action: 'LOGIN_API',
            clientId: $request->input('client_id'),
            request: $request,
            details: ['client_name' => $clientName]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Autentikasi SSO Berhasil',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 7 * 24 * 60 * 60, // 7 hari dalam detik
                'user' => $user->toSsoPayload(),
            ],
        ], 200);
    }

    /**
     * Endpoint: POST /api/v1/sso/token
     * Exchange OAuth2 Authorization Code dengan Access Token
     */
    public function exchangeToken(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'grant_type' => 'required|string|in:authorization_code',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'code' => 'required|string',
            'redirect_uri' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Parameter permohonan token tidak valid',
                'errors' => $validator->errors(),
            ], 422);
        }

        $client = SsoClient::where('client_id', $request->input('client_id'))->first();

        if (! $client || ! $client->verifySecret($request->input('client_secret'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kredensial client SSO tidak valid',
            ], 401);
        }

        if (! $client->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aplikasi klien sedang dinonaktifkan oleh Dinas PUPR Subang',
            ], 403);
        }

        $authCode = SsoAuthCode::where('code', $request->input('code'))
            ->where('client_id', $client->client_id)
            ->first();

        if (! $authCode || ! $authCode->isValid()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authorization code tidak valid atau telah kedaluwarsa',
            ], 400);
        }

        // Tandai kode telah digunakan
        $authCode->markAsUsed();

        $user = $authCode->user;
        if (! $user || ! $user->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan atau berstatus nonaktif',
            ], 403);
        }

        // Generate token
        $token = $user->createToken('client_token_' . $client->code_name, ['*'], now()->addDays(7))->plainTextToken;

        SsoAuditLog::record(
            userId: $user->id,
            action: 'TOKEN_EXCHANGE',
            clientId: $client->client_id,
            request: $request,
            details: ['app_code' => $client->code_name]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Token berhasil diterbitkan',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 7 * 24 * 60 * 60,
            'user' => $user->toSsoPayload(),
        ]);
    }

    /**
     * Endpoint: POST /api/v1/sso/verify-token
     * Memverifikasi keabsahan token dari aplikasi klien
     */
    public function verifyToken(Request $request): JsonResponse
    {
        // Token bisa dikirim via Bearer header atau body parameter 'token'
        $tokenString = $request->bearerToken() ?? $request->input('token');

        if (! $tokenString) {
            return response()->json([
                'status' => 'error',
                'valid' => false,
                'message' => 'Token otentikasi tidak disediakan',
            ], 400);
        }

        $token = PersonalAccessToken::findToken($tokenString);

        if (! $token) {
            return response()->json([
                'status' => 'error',
                'valid' => false,
                'message' => 'Token tidak ditemukan atau telah dibatalkan',
            ], 401);
        }

        // Cek kedaluwarsa
        if ($token->expires_at && $token->expires_at->isPast()) {
            return response()->json([
                'status' => 'error',
                'valid' => false,
                'message' => 'Token telah kedaluwarsa',
            ], 401);
        }

        $user = $token->tokenable;

        if (! $user || ! $user->is_active) {
            return response()->json([
                'status' => 'error',
                'valid' => false,
                'message' => 'Pengguna tidak aktif atau telah dihapus',
            ], 403);
        }

        // Update token last used
        $token->touch();

        return response()->json([
            'status' => 'success',
            'valid' => true,
            'message' => 'Token valid',
            'user' => $user->toSsoPayload(),
            'token_info' => [
                'name' => $token->name,
                'last_used_at' => $token->last_used_at,
                'created_at' => $token->created_at,
            ],
        ]);
    }

    /**
     * Endpoint: GET /api/v1/sso/userinfo atau /api/v1/sso/me
     * Mengambil informasi data pegawai login saat ini
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user->toSsoPayload(),
        ]);
    }

    /**
     * Endpoint: POST /api/v1/sso/logout
     * Single Logout: Mencabut token saat ini
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            // Hapus token yang sedang digunakan
            $request->user()->currentAccessToken()->delete();

            SsoAuditLog::record(
                userId: $user->id,
                action: 'LOGOUT',
                request: $request,
                details: ['type' => 'API_TOKEN_REVOKED']
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil logout dari Single Sign-On Dinas PUPR Subang',
        ]);
    }

    /**
     * Endpoint: POST /api/v1/sso/validate-client
     * Verifikasi integritas client_id dan secret dari aplikasi klien
     */
    public function validateClient(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'valid' => false,
                'message' => 'Parameter tidak lengkap',
            ], 422);
        }

        $client = SsoClient::where('client_id', $request->input('client_id'))->first();

        if (! $client || ! $client->verifySecret($request->input('client_secret'))) {
            return response()->json([
                'status' => 'error',
                'valid' => false,
                'message' => 'Client ID atau Secret tidak cocok',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'valid' => true,
            'client' => [
                'name' => $client->name,
                'code_name' => $client->code_name,
                'bidang' => $client->bidang_terkait,
                'app_url' => $client->app_url,
                'is_active' => $client->is_active,
            ],
        ]);
    }
}

