<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SsoAuditLog;
use App\Models\SsoAuthCode;
use App\Models\SsoClient;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class SsoGoogleAuthController extends Controller
{
    /**
     * Redirect pengguna ke halaman Google OAuth 2.0 (Pilih Akun)
     */
    public function redirect(Request $request): View|RedirectResponse
    {
        // Simpan parameter SSO client jika ada
        if ($request->filled('client_id')) {
            session([
                'sso_client_id' => $request->query('client_id'),
                'sso_redirect_uri' => $request->query('redirect_uri'),
                'sso_state' => $request->query('state'),
            ]);
        }

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        // Jika kredensial Google belum lengkap diisi di .env, tampilkan antarmuka pemilih akun lokal
        if (empty($clientId) || empty($clientSecret)) {
            $availableUsers = User::where('is_active', true)->take(6)->get();
            return view('sso.google-select-account', compact('availableUsers'));
        }

        // Alihkan langsung ke Google OAuth resmi dengan prompt select_account (Memunculkan layar Pilih Akun Google)
        try {
            return Socialite::driver('google')
                ->stateless()
                ->with([
                    'prompt' => 'select_account', // Memaksa Google menampilkan dialog "Pilih Akun" di perangkat pengguna
                    'access_type' => 'offline',
                ])
                ->redirect();
        } catch (Exception $e) {
            return redirect()->route('sso.login')->with('error', 'Gagal menghubungi Google OAuth: ' . $e->getMessage());
        }
    }

    /**
     * Callback setelah login dari Google OAuth resmi
     */
    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (Exception $e) {
            return redirect()->route('sso.login')->with('error', 'Proses otentikasi Google gagal: ' . $e->getMessage() . '. Pastikan GOOGLE_CLIENT_SECRET di file .env sudah sesuai dengan Google Cloud Console.');
        }

        // Cari pegawai berdasarkan google_id atau email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        // Jika user belum ada di database, buat akun baru secara otomatis dari profil Google
        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?: 'Pegawai Google SSO',
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'bidang' => 'Dinas PUPR Subang',
                'jabatan' => 'Pegawai ASN / Pengguna SSO',
                'status_kepegawaian' => 'PNS',
                'role' => 'pegawai',
                'is_active' => true,
                'password' => bcrypt(str()->random(24)),
                'last_login_at' => Carbon::now(),
            ]);
        } else {
            // Update google_id & avatar bila belum tersimpan
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar() ?: $user->avatar,
                'last_login_at' => Carbon::now(),
            ]);
        }

        if (! $user->is_active) {
            return redirect()->route('sso.login')->with('error', 'Status akun pegawai Anda dinonaktifkan. Hubungi IT PUPR Subang.');
        }

        Auth::login($user, true);

        SsoAuditLog::record(
            userId: $user->id,
            action: 'LOGIN_GOOGLE_SSO',
            request: $request,
            details: [
                'channel' => 'google_oauth2',
                'google_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
            ]
        );

        return $this->handlePostLoginRedirect($user);
    }

    /**
     * Simulasi pilih akun Google lokal jika GOOGLE_CLIENT_ID belum diisi
     */
    public function simulateSelectAccount(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($request->input('email')));
        $user = User::where('email', $email)->first();

        // Jika akun email belum terdaftar di database, buat otomatis (seperti perilaku Google OAuth callback)
        if (! $user) {
            $namePart = explode('@', $email)[0];
            $cleanName = ucwords(str_replace(['.', '_', '-'], ' ', $namePart));

            $user = User::create([
                'name' => $cleanName ?: 'Pegawai Google SSO',
                'email' => $email,
                'bidang' => 'Dinas PUPR Subang',
                'jabatan' => 'Pegawai ASN / Pengguna SSO',
                'status_kepegawaian' => 'PNS',
                'role' => 'pegawai',
                'is_active' => true,
                'password' => bcrypt(str()->random(24)),
                'last_login_at' => Carbon::now(),
            ]);
        }

        if (! $user->is_active) {
            return back()->with('error', 'Akun ' . $email . ' dinonaktifkan. Hubungi administrator.');
        }

        Auth::login($user, true);
        $user->update(['last_login_at' => Carbon::now()]);

        SsoAuditLog::record(
            userId: $user->id,
            action: 'LOGIN_GOOGLE_SSO_SIMULATION',
            request: $request,
            details: ['channel' => 'google_sso_simulation', 'email' => $email]
        );

        return $this->handlePostLoginRedirect($user);
    }

    /**
     * Helper setelah login sukses: alihkan ke klien SSO atau dashboard
     */
    protected function handlePostLoginRedirect(User $user): RedirectResponse
    {
        $clientId = session()->pull('sso_client_id');
        $redirectUri = session()->pull('sso_redirect_uri');
        $state = session()->pull('sso_state');

        if ($clientId && $redirectUri) {
            $authCode = SsoAuthCode::createCode(
                clientId: $clientId,
                userId: $user->id,
                redirectUri: $redirectUri,
                ttlMinutes: 5
            );

            SsoAuditLog::record(
                userId: $user->id,
                action: 'AUTH_CODE_GENERATED',
                clientId: $clientId,
                details: ['code_id' => $authCode->id, 'channel' => 'google_sso']
            );

            $delimiter = str_contains($redirectUri, '?') ? '&' : '?';
            $targetUrl = $redirectUri . $delimiter . 'code=' . urlencode($authCode->code);
            if ($state) {
                $targetUrl .= '&state=' . urlencode($state);
            }

            return redirect()->away($targetUrl);
        }

        return redirect()->route('sso.dashboard')->with('success', 'Selamat datang ' . $user->name . '! Berhasil masuk via Google SSO Dinas PUPR Subang.');
    }
}

