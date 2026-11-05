<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SsoFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Butir 4 (Bagian Proteksi): Pengguna belum login harus diarahkan ke gerbang login SSO
     */
    public function test_unauthenticated_user_redirected_to_sso_gateway(): void
    {
        $this->get('/')->assertRedirect('/login');
        $this->get('/portal')->assertRedirect('/login');
        $this->get('/layanan/akademik')->assertRedirect('/login');
        $this->get('/layanan/elearning')->assertRedirect('/login');
        $this->get('/layanan/perpustakaan')->assertRedirect('/login');
    }

    /**
     * Butir 2: Halaman Gerbang Login (SSO Gateway) dapat dibuka dengan baik
     */
    public function test_sso_gateway_renders_successfully(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('POLITEKNIK');
        $response->assertSee('Gerbang');
        $response->assertSee('Akun Google');
    }

    /**
     * Butir 1: Autentikasi IdP SSO (Simulasi Login / Socialite Sync)
     */
    public function test_mock_sso_login_authenticates_user_and_redirects_to_portal(): void
    {
        $response = $this->get('/auth/mock-login?account=mahasiswa');

        $response->assertRedirect('/portal');
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'dimas.pratama@mhs.politeknik.ac.id',
            'name' => 'Dimas Pratama (Mahasiswa)',
        ]);
    }

    /**
     * Butir 3 & 4: Bebas keluar-masuk lintas layanan (Akademik, E-Learning, Perpustakaan) tanpa password lagi
     */
    public function test_seamless_cross_service_access_without_reauthentication(): void
    {
        $user = User::factory()->create([
            'name' => 'Dimas Pratama',
            'email' => 'dimas@politeknik.ac.id',
            'google_id' => 'google-test-12345',
            'avatar' => 'https://ui-avatars.com/api/?name=Dimas',
        ]);

        // Autentikasi satu kali di awal (Single Sign-On)
        $this->actingAs($user);

        // Akses Portal Utama (Butir 3)
        $portalResponse = $this->get('/portal');
        $portalResponse->assertStatus(200);
        $portalResponse->assertSee('Dimas Pratama');
        $portalResponse->assertSee('Portal Akademik');
        $portalResponse->assertSee('E-Learning');
        $portalResponse->assertSee('Perpustakaan Digital');

        // Pindah ke Layanan Akademik
        $akademikResponse = $this->get('/layanan/akademik');
        $akademikResponse->assertStatus(200);
        $akademikResponse->assertSee('Sistem Informasi Akademik');
        $akademikResponse->assertSee('Arsitektur Web Service');

        // Pindah ke Layanan E-Learning (Bebas tanpa login ulang)
        $elearningResponse = $this->get('/layanan/elearning');
        $elearningResponse->assertStatus(200);
        $elearningResponse->assertSee('Learning Management System');
        $elearningResponse->assertSee('Web Service & Single Sign-On');

        // Pindah ke Layanan Perpustakaan (Bebas tanpa login ulang)
        $perpusResponse = $this->get('/layanan/perpustakaan');
        $perpusResponse->assertStatus(200);
        $perpusResponse->assertSee('Perpustakaan Digital');
        $perpusResponse->assertSee('Mastering API Architecture');
    }

    /**
     * Pengujian Single Sign-Out (Logout Serentak dari seluruh layanan)
     */
    public function test_single_sign_out_terminates_all_service_access(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Lakukan logout
        $response = $this->post('/logout');
        $response->assertRedirect('/login');
        $this->assertGuest();

        // Setelah logout, akses ke modul layanan kembali dihadang
        $this->get('/layanan/akademik')->assertRedirect('/login');
    }
}

