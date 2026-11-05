<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Tampilkan Gerbang Login SSO
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('portal');
        }

        $isGoogleConfigured = !empty(config('services.google.client_id')) && !empty(config('services.google.client_secret'));

        return view('auth.login', compact('isGoogleConfigured'));
    }

    /**
     * Redirect pengguna ke Google Identity Provider (IdP)
     */
    public function redirectToGoogle()
    {
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->with('warning', 'Konfigurasi Google Client ID & Secret belum diisi di .env. Kamu bisa gunakan tombol "Simulasi SSO Google" di bawah untuk mencoba alur SSO secara instan!');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Tangani callback balik dari Google setelah pengguna berhasil autentikasi
     */
    public function handleGoogleCallback()
    {
        try {
            // Gunakan stateless() agar kebal terhadap issue cross-domain session/cookie di localhost
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]
            );

            Auth::login($user, true);

            return redirect()->route('portal')->with('success', "Selamat datang, {$user->name}! Autentikasi SSO Google berhasil.");
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Google SSO Callback Error: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            $message = $e->getMessage() ?: 'Sesi autentikasi kadaluarsa atau state tidak valid. Silakan coba login kembali.';
            return redirect()->route('login')->with('error', 'Gagal melakukan autentikasi SSO dengan Google: ' . $message);
        }
    }

    /**
     * Simulasi IdP SSO (Mock Login) untuk pengujian cepat / demo offline
     */
    public function mockLogin(Request $request)
    {
        $role = $request->input('account', 'mahasiswa');

        if ($role === 'dosen') {
            $name = 'Dr. Eng. Hendra Wijaya, M.T.';
            $email = 'hendra.wijaya@politeknik.ac.id';
            $googleId = 'google-mock-dosen-102938475';
            $avatar = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80';
        } else {
            $name = 'Dimas Pratama (Mahasiswa)';
            $email = 'dimas.pratama@mhs.politeknik.ac.id';
            $googleId = 'google-mock-mhs-987654321';
            $avatar = 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80';
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'google_id' => $googleId,
                'avatar' => $avatar,
            ]
        );

        Auth::login($user, true);

        return redirect()->route('portal')->with('success', "Simulasi SSO Google Berhasil! Masuk sebagai {$user->name}.");
    }

    /**
     * Single Sign-Out (Logout dari seluruh layanan kampus)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil Logout dari SSO Gateway. Sesi seluruh layanan kampus telah ditutup.');
    }
}

