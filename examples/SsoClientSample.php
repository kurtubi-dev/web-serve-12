<?php

/**
 * CONTOH KODE INTEGRASI APLIKASI KLIEN DENGAN SSO DINAS PUPR KABUPATEN SUBANG
 *
 * Contoh ini mendemonstrasikan bagaimana aplikasi klien (seperti SIM-JALAN atau SI-IRIGASI)
 * berkomunikasi dengan Web Service SSO Terpadu.
 */

class PuprSsoClient
{
    private string $ssoBaseUrl;
    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;

    public function __construct(
        string $ssoBaseUrl = 'http://127.0.0.1:8000',
        string $clientId = 'pupr_simjalan_subang_2026',
        string $clientSecret = 'sec_simjalan_subang_9f83a48e71b29a10',
        string $redirectUri = 'http://127.0.0.1:8001/auth/sso/callback'
    ) {
        $this->ssoBaseUrl = rtrim($ssoBaseUrl, '/');
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
    }

    /**
     * Langkah 1: Arahkan browser user ke Portal SSO PUPR Subang untuk login
     */
    public function getLoginUrl(?string $state = null): string
    {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'state' => $state ?? bin2hex(random_bytes(16)),
        ];

        return $this->ssoBaseUrl . '/sso/authorize?' . http_build_query($params);
    }

    /**
     * Langkah 2: Tukarkan Authorization Code dari callback menjadi Access Token & User Profile
     */
    public function handleCallback(string $code): ?array
    {
        $endpoint = $this->ssoBaseUrl . '/api/v1/sso/token';

        $payload = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            return json_decode($response, true);
        }

        return null;
    }

    /**
     * Langkah 3: Verifikasi Token yang aktif
     */
    public function verifyToken(string $accessToken): ?array
    {
        $endpoint = $this->ssoBaseUrl . '/api/v1/sso/verify-token';

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Accept: application/json',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            return json_decode($response, true);
        }

        return null;
    }

    /**
     * Direct Login via API (Untuk Mobile App / Petugas Lapangan PUPR Subang)
     */
    public function directApiLogin(string $nipOrEmail, string $password): ?array
    {
        $endpoint = $this->ssoBaseUrl . '/api/v1/sso/login';

        $payload = [
            'identifier' => $nipOrEmail,
            'password' => $password,
            'client_id' => $this->clientId,
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            return json_decode($response, true);
        }

        return null;
    }
}

