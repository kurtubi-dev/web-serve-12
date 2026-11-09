<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SsoAuditLog;
use App\Models\SsoAuthCode;
use App\Models\SsoClient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SsoPortalController extends Controller
{
    /**
     * Dashboard Portal Satu Pintu Dinas PUPR Kabupaten Subang
     */
    public function dashboard(Request $request): View|RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('sso.login');
        }

        $user = Auth::user();
        $clients = SsoClient::where('is_active', true)->get();
        $recentLogs = SsoAuditLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('sso.dashboard', compact('user', 'clients', 'recentLogs'));
    }

    /**
     * Tampilan Halaman Login SSO
     */
    public function showLogin(Request $request): View|RedirectResponse
    {
        $clientId = $request->query('client_id');
        $redirectUri = $request->query('redirect_uri');
        $state = $request->query('state');

        // Jika user sudah login dan sedang meminta otorisasi client
        if (Auth::check() && $clientId) {
            return $this->handleExistingSessionAuthorize($clientId, $redirectUri, $state);
        }

        // Jika user sudah login dan tidak ada permintaan client, lempar ke dashboard
        if (Auth::check()) {
            return redirect()->route('sso.dashboard');
        }

        $client = null;
        if ($clientId) {
            $client = SsoClient::where('client_id', $clientId)->where('is_active', true)->first();
        }

        return view('sso.login', compact('clientId', 'redirectUri', 'state', 'client'));
    }

    /**
     * Proses Autentikasi Login SSO Form
     */
    public function processLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
            'client_id' => 'nullable|string',
            'redirect_uri' => 'nullable|string',
            'state' => 'nullable|string',
        ]);

        $identifier = $request->input('identifier');
        $password = $request->input('password');

        $user = User::where('email', $identifier)
            ->orWhere('nip', $identifier)
            ->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            SsoAuditLog::record(
                userId: $user?->id,
                action: 'FAILED_LOGIN',
                clientId: $request->input('client_id'),
                request: $request,
                details: ['identifier' => $identifier, 'channel' => 'web_portal']
            );

            return back()->withInput()->withErrors([
                'identifier' => 'NIP/Email atau password salah!',
            ]);
        }

        if (! $user->is_active) {
            return back()->withInput()->withErrors([
                'identifier' => 'Status pegawai Anda non-aktif. Silakan hubungi IT PUPR Subang.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $user->update(['last_login_at' => Carbon::now()]);

        SsoAuditLog::record(
            userId: $user->id,
            action: 'LOGIN_WEB',
            clientId: $request->input('client_id'),
            request: $request,
            details: ['channel' => 'web_portal']
        );

        $clientId = $request->input('client_id');
        $redirectUri = $request->input('redirect_uri');
        $state = $request->input('state');

        if ($clientId && $redirectUri) {
            return $this->generateCodeAndRedirect($user, $clientId, $redirectUri, $state);
        }

        return redirect()->route('sso.dashboard')->with('success', 'Selamat datang di Portal SSO Dinas PUPR Kabupaten Subang!');
    }

    /**
     * Handle SSO Authorize flow (/sso/authorize)
     */
    public function authorizeApp(Request $request): View|RedirectResponse
    {
        $clientId = $request->query('client_id');
        $redirectUri = $request->query('redirect_uri');
        $state = $request->query('state');

        if (! $clientId || ! $redirectUri) {
            return redirect()->route('sso.login')->with('error', 'Parameter client_id dan redirect_uri wajib disertakan.');
        }

        $client = SsoClient::where('client_id', $clientId)->where('is_active', true)->first();

        if (! $client) {
            abort(404, 'Aplikasi klien SSO tidak terdaftar di sistem Dinas PUPR Subang.');
        }

        if (! Auth::check()) {
            return redirect()->route('sso.login', [
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'state' => $state,
            ]);
        }

        // Tampilkan halaman konfirmasi otorisasi jika diperlukan, atau langsung terbitkan code
        $user = Auth::user();

        // Otorisasi otomatis untuk aplikasi internal resmi PUPR Subang
        return $this->generateCodeAndRedirect($user, $clientId, $redirectUri, $state);
    }

    /**
     * Logout Session
     */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            SsoAuditLog::record(
                userId: Auth::id(),
                action: 'LOGOUT',
                request: $request,
                details: ['channel' => 'web_portal']
            );
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sso.login')->with('success', 'Anda telah berhasil keluar dari SSO Dinas PUPR Subang.');
    }

    /**
     * Dokumentasi API SSO
     */
    public function documentation(): View
    {
        $clients = SsoClient::all();
        return view('sso.docs', compact('clients'));
    }

    /**
     * Helper membuat auth code dan redirect ke aplikasi klien
     */
    protected function generateCodeAndRedirect(User $user, string $clientId, string $redirectUri, ?string $state = null): RedirectResponse
    {
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
            details: ['code_id' => $authCode->id]
        );

        $delimiter = str_contains($redirectUri, '?') ? '&' : '?';
        $targetUrl = $redirectUri . $delimiter . 'code=' . urlencode($authCode->code);

        if ($state) {
            $targetUrl .= '&state=' . urlencode($state);
        }

        return redirect()->away($targetUrl);
    }

    /**
     * Helper jika session sudah ada
     */
    protected function handleExistingSessionAuthorize(string $clientId, ?string $redirectUri, ?string $state): RedirectResponse
    {
        $client = SsoClient::where('client_id', $clientId)->where('is_active', true)->first();

        if (! $client) {
            return redirect()->route('sso.dashboard');
        }

        $targetRedirect = $redirectUri ?: $client->redirect_uri;

        return $this->generateCodeAndRedirect(Auth::user(), $clientId, $targetRedirect, $state);
    }
}

