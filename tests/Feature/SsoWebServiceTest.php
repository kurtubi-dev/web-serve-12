<?php

namespace Tests\Feature;

use App\Models\SsoAuthCode;
use App\Models\SsoClient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SsoWebServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test web login page can be rendered
     */
    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Dinas PUPR Subang');
        $response->assertSee('Portal Masuk Pegawai');
    }

    /**
     * Test direct API login with NIP and password
     */
    public function test_direct_api_login_successful(): void
    {
        $response = $this->postJson('/api/v1/sso/login', [
            'identifier' => '198501012010011001',
            'password' => 'password',
            'client_id' => 'pupr_simjalan_subang_2026',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'token',
                    'token_type',
                    'user' => [
                        'id',
                        'nip',
                        'name',
                        'email',
                        'bidang',
                        'jabatan',
                        'instansi',
                    ],
                ],
            ]);
    }

    /**
     * Test token verification endpoint
     */
    public function test_verify_token_endpoint(): void
    {
        $user = User::where('nip', '198501012010011001')->first();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->postJson('/api/v1/sso/verify-token', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'valid' => true,
            ])
            ->assertJsonPath('user.nip', '198501012010011001');
    }

    /**
     * Test OAuth2 Authorization code generation & token exchange
     */
    public function test_oauth_token_exchange(): void
    {
        $client = SsoClient::where('code_name', 'sim-jalan')->first();
        $user = User::where('nip', '197805202005011008')->first(); // Kabid Bina Marga

        $authCode = SsoAuthCode::createCode(
            clientId: $client->client_id,
            userId: $user->id,
            redirectUri: 'http://simjalan.pupr.subang.go.id/auth/sso/callback'
        );

        $response = $this->postJson('/api/v1/sso/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $client->client_id,
            'client_secret' => $client->client_secret,
            'code' => $authCode->code,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'access_token',
                'token_type',
                'user' => [
                    'nip',
                    'name',
                    'bidang',
                ],
            ])
            ->assertJsonPath('user.bidang', 'Bidang Bina Marga');
    }

    /**
     * Test protected userinfo / me endpoint
     */
    public function test_userinfo_endpoint(): void
    {
        $user = User::where('nip', '198501012010011001')->first();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/sso/me');

        $response->assertStatus(200)
            ->assertJsonPath('data.nip', '198501012010011001')
            ->assertJsonPath('data.role', 'superadmin');
    }

    /**
     * Test list bidang endpoint
     */
    public function test_list_bidang_endpoint(): void
    {
        $response = $this->getJson('/api/v1/sso/bidang-list');

        $response->assertStatus(200)
            ->assertJsonPath('instansi', 'Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Subang')
            ->assertJsonStructure([
                'status',
                'instansi',
                'bidang',
            ]);
    }
}