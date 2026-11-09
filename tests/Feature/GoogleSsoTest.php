<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleSsoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_google_redirect_redirects_to_google_oauth_screen(): void
    {
        config([
            'services.google.client_id' => '187216074436-test.apps.googleusercontent.com',
            'services.google.client_secret' => 'test_secret',
        ]);

        $response = $this->get(route('sso.google'));

        $response->assertStatus(302);
        $redirectUrl = $response->headers->get('Location');
        $this->assertStringContainsString('accounts.google.com/o/oauth2', $redirectUrl);
        $this->assertStringContainsString('prompt=select_account', $redirectUrl);
    }

    public function test_google_redirect_shows_fallback_selection_when_no_client_id(): void
    {
        config(['services.google.client_id' => null]);

        $response = $this->get(route('sso.google'));

        $response->assertStatus(200);
        $response->assertSee('Login dengan Google SSO');
        $response->assertSee('Pilih akun Google Anda');
    }

    public function test_google_simulation_login_successfully(): void
    {
        $user = User::where('is_active', true)->first();

        $response = $this->post(route('sso.google.simulate'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('sso.dashboard'));
        $this->assertAuthenticatedAs($user);
    }
}
