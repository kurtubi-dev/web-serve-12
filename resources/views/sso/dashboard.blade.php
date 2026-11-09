@extends('layouts.app')

@section('title', 'Portal Satu Pintu Aplikasi PUPR Subang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Hero / Welcome Banner Pegawai -->
    <div class="rounded-2xl bg-gradient-to-r from-pupr-deep via-blue-900 to-slate-900 text-white p-6 sm:p-8 shadow-xl relative overflow-hidden">
        <!-- Background Pattern Decor -->
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl">
            <i class="fa-solid fa-helmet-safety"></i>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-start sm:items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-pupr-yellow to-amber-300 text-pupr-deep flex items-center justify-center font-extrabold text-2xl shadow-lg border-2 border-white/20">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-400 text-slate-950 uppercase">
                            {{ $user->role }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-blue-800/80 text-blue-100">
                            {{ $user->status_kepegawaian ?? 'ASN' }}
                        </span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight">{{ $user->name }}</h2>
                    <p class="text-xs sm:text-sm text-blue-200 mt-0.5">
                        <span class="font-mono">NIP. {{ $user->nip ?? '-' }}</span> &bull; {{ $user->jabatan }}
                    </p>
                </div>
            </div>

            <!-- Detail Info Badge -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 w-full md:w-auto text-xs bg-white/10 backdrop-blur-md p-3.5 rounded-xl border border-white/10">
                <div>
                    <div class="text-blue-300 text-[10px] uppercase font-semibold">Unit Kerja / Bidang</div>
                    <div class="font-bold text-white mt-0.5 truncate">{{ $user->bidang ?? 'Sekretariat' }}</div>
                </div>
                <div>
                    <div class="text-blue-300 text-[10px] uppercase font-semibold">Pangkat / Gol</div>
                    <div class="font-bold text-white mt-0.5">{{ $user->pangkat_golongan ?? '-' }}</div>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <div class="text-blue-300 text-[10px] uppercase font-semibold">Status SSO</div>
                    <div class="font-bold text-emerald-400 mt-0.5 flex items-center">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span> Terverifikasi
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seksi: Daftar Aplikasi Sektoral Dinas PUPR Kab. Subang -->
    <div>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-2">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900 flex items-center">
                    <i class="fa-solid fa-shapes text-pupr-deep mr-2.5"></i>
                    Aplikasi Terintegrasi SSO PUPR Subang
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Klik aplikasi untuk masuk langsung tanpa login ulang menggunakan identitas SSO Anda.</p>
            </div>
            <span class="text-xs font-bold text-slate-600 bg-slate-200 px-3 py-1 rounded-lg">
                {{ $clients->count() }} Aplikasi Terdaftar
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($clients as $client)
                <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition-all duration-200 p-6 flex flex-col justify-between group">
                    <div>
                        <!-- Header Card -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white text-xl shadow-md transition-transform group-hover:scale-105"
                                 style="background-color: {{ $client->badge_color ?? '#0F3B66' }};">
                                @if($client->icon_url == 'road')
                                    <i class="fa-solid fa-road"></i>
                                @elseif($client->icon_url == 'droplet')
                                    <i class="fa-solid fa-droplet"></i>
                                @elseif($client->icon_url == 'building-2')
                                    <i class="fa-solid fa-city"></i>
                                @elseif($client->icon_url == 'map-pin')
                                    <i class="fa-solid fa-map-location-dot"></i>
                                @elseif($client->icon_url == 'hard-hat')
                                    <i class="fa-solid fa-trowel-bricks"></i>
                                @else
                                    <i class="fa-solid fa-laptop-code"></i>
                                @endif
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                                {{ $client->bidang_terkait ?? 'PUPR Subang' }}
                            </span>
                        </div>

                        <h4 class="text-base font-bold text-slate-900 group-hover:text-pupr-deep transition">
                            {{ $client->name }}
                        </h4>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed line-clamp-2">
                            {{ $client->description }}
                        </p>
                    </div>

                    <!-- Action Launch Button -->
                    <div class="pt-5 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] font-mono text-slate-400">
                            {{ $client->code_name }}
                        </span>
                        <a href="{{ route('sso.authorize', ['client_id' => $client->client_id, 'redirect_uri' => explode(',', $client->redirect_uri)[0]]) }}"
                           target="_blank"
                           class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-900 text-white hover:bg-pupr-deep shadow-xs transition">
                            <span>Akses SSO</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 p-8 text-center bg-white rounded-2xl border border-slate-200">
                    <p class="text-sm text-slate-500">Belum ada aplikasi klien yang terdaftar di SSO PUPR Subang.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Seksi: Tool Developer / Integrator SSO -->
    <div class="bg-slate-900 rounded-2xl text-slate-100 p-6 sm:p-8 shadow-xl">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <span class="text-xs font-bold text-pupr-yellow uppercase tracking-wider">Web Service Integrator &bull; Developer Tools</span>
                <h3 class="text-lg font-bold text-white mt-1">Uji Coba API SSO Web Service</h3>
                <p class="text-xs text-slate-400 mt-0.5">Tes komunikasi REST API untuk aplikasi klien internal PUPR Subang langsung dari browser.</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('sso.docs') }}" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-bold text-white border border-white/20 transition flex items-center space-x-2">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Baca Panduan API</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-mono">
            <div class="bg-slate-950 p-4 rounded-xl border border-slate-800">
                <div class="text-slate-400 mb-1 flex items-center justify-between">
                    <span>1. Endpoint Login (POST):</span>
                    <span class="text-emerald-400 font-bold">POST</span>
                </div>
                <div class="text-pupr-yellow select-all truncate">
                    {{ url('/api/v1/sso/login') }}
                </div>
                <div class="mt-2 text-slate-500 text-[11px]">
                    Kirim JSON: <code class="text-slate-300">{"identifier": "{{ $user->nip }}", "password": "password"}</code>
                </div>
            </div>

            <div class="bg-slate-950 p-4 rounded-xl border border-slate-800">
                <div class="text-slate-400 mb-1 flex items-center justify-between">
                    <span>2. Endpoint Verifikasi Token (POST):</span>
                    <span class="text-blue-400 font-bold">POST</span>
                </div>
                <div class="text-pupr-yellow select-all truncate">
                    {{ url('/api/v1/sso/verify-token') }}
                </div>
                <div class="mt-2 text-slate-500 text-[11px]">
                    Kirim Header: <code class="text-slate-300">Authorization: Bearer &lt;token&gt;</code>
                </div>
            </div>
        </div>
    </div>

    <!-- Seksi: Audit Trail Keamanan SSO (Khusus Superadmin/Admin) -->
    @if($user->isSuperAdmin() && count($recentLogs) > 0)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-base font-bold text-slate-900 flex items-center">
                    <i class="fa-solid fa-shield-virus text-blue-600 mr-2"></i>
                    Audit Trail & Log Autentikasi SSO Terkini
                </h4>
                <span class="text-xs text-slate-400 font-medium">10 Aktivitas Terakhir</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold text-[10px]">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Waktu</th>
                            <th class="px-4 py-3">Pegawai / User</th>
                            <th class="px-4 py-3">Aktivitas</th>
                            <th class="px-4 py-3">Client ID</th>
                            <th class="px-4 py-3 rounded-r-lg">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentLogs as $log)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-4 py-3 font-mono text-[11px] text-slate-500">
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="px-4 py-3 font-semibold text-slate-900">
                                    {{ $log->user ? $log->user->name : 'Sistem / Tamu' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded font-mono text-[10px] font-bold
                                        {{ str_contains($log->action, 'FAILED') ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-mono text-[11px] text-slate-500">
                                    {{ $log->client_id ?? '-' }}
                                </td>
                                <td class="px-4 py-3 font-mono text-[11px] text-slate-500">
                                    {{ $log->ip_address ?? '127.0.0.1' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection

