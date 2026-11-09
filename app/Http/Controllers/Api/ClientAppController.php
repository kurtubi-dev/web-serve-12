<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SsoClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClientAppController extends Controller
{
    /**
     * Endpoint: GET /api/v1/sso/clients
     * Mendapatkan daftar aplikasi terintegrasi
     */
    public function index(): JsonResponse
    {
        $clients = SsoClient::where('is_active', true)
            ->select('id', 'client_id', 'name', 'code_name', 'description', 'app_url', 'icon_url', 'badge_color', 'bidang_terkait')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $clients,
        ]);
    }

    /**
     * Endpoint: POST /api/v1/sso/clients
     * Registrasi aplikasi internal Dinas PUPR baru (Hanya Superadmin)
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'code_name' => 'required|string|max:50|unique:sso_clients,code_name',
            'redirect_uri' => 'required|string',
            'app_url' => 'nullable|url',
            'description' => 'nullable|string',
            'bidang_terkait' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = SsoClient::generateCredentials($request->input('code_name'));

        $client = SsoClient::create([
            'client_id' => $credentials['client_id'],
            'client_secret' => $credentials['client_secret'],
            'name' => $request->input('name'),
            'code_name' => Str::slug($request->input('code_name')),
            'description' => $request->input('description'),
            'app_url' => $request->input('app_url'),
            'redirect_uri' => $request->input('redirect_uri'),
            'bidang_terkait' => $request->input('bidang_terkait'),
            'allowed_scopes' => ['profile', 'nip', 'bidang'],
            'is_active' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Aplikasi klien SSO berhasil didaftarkan',
            'data' => [
                'client_id' => $client->client_id,
                'client_secret' => $client->client_secret,
                'name' => $client->name,
                'code_name' => $client->code_name,
                'redirect_uri' => $client->redirect_uri,
            ],
            'note' => 'Simpan client_secret ini di konfigurasi .env aplikasi klien Anda!',
        ], 201);
    }
}

