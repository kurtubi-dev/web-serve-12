@extends('layouts.app')

@section('title', 'Dokumentasi Web Service SSO Dinas PUPR Subang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Header Dokumentasi -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="px-2.5 py-1 rounded bg-blue-100 text-pupr-deep text-xs font-bold uppercase tracking-wider">
                    API Specification v1.0
                </span>
                <h2 class="text-2xl font-extrabold text-slate-900 mt-2">
                    Dokumentasi Integrasi Web Service SSO Dinas PUPR Subang
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Panduan teknis bagi tim pengembang aplikasi untuk mengintegrasikan otentikasi terpusat (Single Sign-On).
                </p>
            </div>
            <a href="{{ route('sso.dashboard') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-xs font-bold text-slate-700 transition flex items-center space-x-1.5">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Portal</span>
            </a>
        </div>
    </div>

    <!-- Dua Mode Integrasi SSO -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-pupr-deep flex items-center justify-center font-bold text-lg mb-3">
                <i class="fa-solid fa-globe"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900">1. Skema Web SSO (Authorization Code Flow)</h3>
            <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                Cocok untuk aplikasi berbasis Web (Laravel, CI, Node.js). Pengguna yang belum login akan dialihkan ke halaman SSO PUPR Subang. Setelah sukses login, SSO akan mengarahkan pengguna kembali ke aplikasi klien membawa parameter <code class="text-pink-600 bg-pink-50 px-1 rounded">?code=...</code> yang dapat ditukarkan dengan data profil pengguna.
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg mb-3">
                <i class="fa-solid fa-mobile-screen-button"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900">2. Skema Direct REST API (Bearer Token)</h3>
            <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                Cocok untuk aplikasi mobile Android/iOS, aplikasi lapangan petugas PUPR, atau Single Page App (Vue/React). Aplikasi mengirimkan NIP dan Password langsung ke Web Service SSO untuk mendapatkan token otentikasi Sanctum.
            </p>
        </div>
    </div>

    <!-- Detail Endpoint API -->
    <div class="space-y-6">
        <h3 class="text-lg font-extrabold text-slate-900 flex items-center">
            <i class="fa-solid fa-network-wired text-pupr-deep mr-2"></i>
            Daftar Endpoint Web Service
        </h3>

        <!-- Endpoint 1: Login API -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center space-x-3">
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-mono text-xs font-bold">POST</span>
                    <span class="font-mono text-xs sm:text-sm font-semibold text-slate-800">/api/v1/sso/login</span>
                </div>
                <span class="text-xs text-slate-500 font-medium">Autentikasi Pegawai & Terbitkan Token</span>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Request Body (JSON)</h5>
                    <pre class="bg-slate-900 text-slate-100 p-4 rounded-xl text-xs font-mono overflow-x-auto">{
  "identifier": "198501012010011001",   // NIP atau Email dinas
  "password": "password",
  "client_id": "pupr_simjalan_subang_2026" // Opsional
}</pre>
                </div>
                <div>
                    <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Response Success (200 OK)</h5>
                    <pre class="bg-slate-900 text-slate-100 p-4 rounded-xl text-xs font-mono overflow-x-auto">{
  "status": "success",
  "message": "Autentikasi SSO Berhasil",
  "data": {
    "token": "1|qXy...example_token",
    "token_type": "Bearer",
    "expires_in": 604800,
    "user": {
      "id": 1,
      "nip": "198501012010011001",
      "name": "Administrator IT PUPR Subang",
      "email": "admin.it@pupr.subang.go.id",
      "phone_number": "081234567890",
      "bidang": "Sekretariat",
      "jabatan": "Pranata Komputer Ahli Muda / Admin SSO",
      "status_kepegawaian": "PNS",
      "role": "superadmin",
      "instansi": "Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Subang"
    }
  }
}</pre>
                </div>
            </div>
        </div>

        <!-- Endpoint 2: Verify Token -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center space-x-3">
                    <span class="px-2.5 py-1 rounded-lg bg-blue-600 text-white font-mono text-xs font-bold">POST</span>
                    <span class="font-mono text-xs sm:text-sm font-semibold text-slate-800">/api/v1/sso/verify-token</span>
                </div>
                <span class="text-xs text-slate-500 font-medium">Validasi Token dari Client App</span>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-xs text-slate-600">
                    Aplikasi klien dapat memverifikasi apakah token yang dibawa pengguna masih valid dan mendapatkan identitas pegawai ter-update.
                </p>
                <div>
                    <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Header / Parameter</h5>
                    <pre class="bg-slate-900 text-slate-100 p-4 rounded-xl text-xs font-mono overflow-x-auto">Authorization: Bearer &lt;sso_access_token&gt;
// ATAU kirim body: {"token": "&lt;sso_access_token&gt;"}</pre>
                </div>
            </div>
        </div>

        <!-- Endpoint 3: Token Exchange (OAuth Code) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center space-x-3">
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-mono text-xs font-bold">POST</span>
                    <span class="font-mono text-xs sm:text-sm font-semibold text-slate-800">/api/v1/sso/token</span>
                </div>
                <span class="text-xs text-slate-500 font-medium">Tukar Authorization Code dengan Token</span>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Request Body (JSON)</h5>
                    <pre class="bg-slate-900 text-slate-100 p-4 rounded-xl text-xs font-mono overflow-x-auto">{
  "grant_type": "authorization_code",
  "client_id": "pupr_simjalan_subang_2026",
  "client_secret": "sec_simjalan_subang_9f83a48e71b29a10",
  "code": "auth_code_yang_didapat_dari_redirect"
}</pre>
                </div>
            </div>
        </div>

        <!-- Endpoint 4: Data Pegawai & Bidang -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center space-x-3">
                    <span class="px-2.5 py-1 rounded-lg bg-purple-600 text-white font-mono text-xs font-bold">GET</span>
                    <span class="font-mono text-xs sm:text-sm font-semibold text-slate-800">/api/v1/sso/pegawai</span>
                </div>
                <span class="text-xs text-slate-500 font-medium">Pencarian & Sinkronisasi Pegawai PUPR Subang</span>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-xs text-slate-600">
                    Query parameters: <code class="bg-slate-100 px-1 py-0.5 rounded font-mono">?bidang=Bina Marga</code>, <code class="bg-slate-100 px-1 py-0.5 rounded font-mono">?search=Ahmad</code>, <code class="bg-slate-100 px-1 py-0.5 rounded font-mono">?status=PNS</code>
                </p>
                <div>
                    <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Header Wajib</h5>
                    <pre class="bg-slate-900 text-slate-100 p-4 rounded-xl text-xs font-mono overflow-x-auto">Authorization: Bearer &lt;sso_access_token&gt;</pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Applications Kredensial Uji Coba -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-4">
        <h3 class="text-base font-bold text-slate-900 flex items-center">
            <i class="fa-solid fa-key text-amber-500 mr-2"></i>
            Daftar Client ID & Secret untuk Uji Coba Integrasi
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 uppercase font-semibold text-[10px]">
                    <tr>
                        <th class="px-4 py-3 rounded-l-lg">Aplikasi</th>
                        <th class="px-4 py-3">Bidang</th>
                        <th class="px-4 py-3">Client ID</th>
                        <th class="px-4 py-3 rounded-r-lg">Client Secret</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono text-[11px]">
                    @foreach($clients as $c)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3 font-bold font-sans text-slate-900">{{ $c->name }}</td>
                            <td class="px-4 py-3 font-sans text-slate-600">{{ $c->bidang_terkait }}</td>
                            <td class="px-4 py-3 text-blue-700 select-all">{{ $c->client_id }}</td>
                            <td class="px-4 py-3 text-slate-500 select-all">{{ $c->client_secret }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

