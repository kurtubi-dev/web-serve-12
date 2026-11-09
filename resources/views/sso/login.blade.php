@extends('layouts.app')

@section('title', 'Login Single Sign-On (SSO)')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">

        <!-- Sisi Kiri: Branding & Informasi SSO Dinas PUPR Subang -->
        <div class="lg:col-span-6 space-y-6">
            <div class="space-y-4">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200/80 text-pupr-deep text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span>Single Sign-On &bull; Dinas PUPR Subang</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Satu Pintu Akses Seluruh Layanan Digital <span class="text-pupr-deep">Dinas PUPR Subang</span>
                </h1>

                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                    Sistem otentikasi terpusat terintegrasi untuk pegawai. Cukup satu akun untuk mengakses seluruh ekosistem aplikasi kedinasan: Bina Marga, Sumber Daya Air, Cipta Karya, Tata Ruang, hingga Jasa Konstruksi.
                </p>
            </div>

            <!-- Fitur Utama Minimalis -->
            <div class="space-y-3.5 pt-2">
                <div class="flex items-center space-x-3 text-slate-700 text-xs sm:text-sm font-semibold">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 border border-emerald-200">
                        <i class="fa-solid fa-check text-xs"></i>
                    </div>
                    <span>Cukup satu kali login untuk seluruh aplikasi sektoral</span>
                </div>

                <div class="flex items-center space-x-3 text-slate-700 text-xs sm:text-sm font-semibold">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 border border-blue-200">
                        <i class="fa-brands fa-google text-xs"></i>
                    </div>
                    <span>Dukungan otentikasi cepat via Google SSO Dinas</span>
                </div>

                <div class="flex items-center space-x-3 text-slate-700 text-xs sm:text-sm font-semibold">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 border border-amber-200">
                        <i class="fa-solid fa-shield-halved text-xs"></i>
                    </div>
                    <span>Keamanan data terpusat dengan protokol enkripsi TLS 1.3</span>
                </div>
            </div>

            <!-- Bantuan Login -->
            <div class="pt-4 border-t border-slate-200 text-xs text-slate-500">
                Lupa kata sandi atau butuh akun baru?
                <button type="button" onclick="document.getElementById('modal-help').classList.remove('hidden')" class="text-pupr-deep font-bold hover:underline ml-1">
                    Hubungi Tim IT Kepegawaian
                </button>
            </div>
        </div>

        <!-- Sisi Kanan: Kartu Form Login SSO -->
        <div class="lg:col-span-6">
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl shadow-slate-900/5 p-7 sm:p-9 relative">

                @if($client)
                    <!-- Notice Permintaan dari Aplikasi Klien -->
                    <div class="mb-5 p-3.5 rounded-2xl bg-amber-50 border border-amber-200 flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        </div>
                        <div class="text-xs">
                            <div class="font-bold text-amber-900">Permintaan Masuk dari:</div>
                            <div class="font-semibold text-amber-800">{{ $client->name }}</div>
                        </div>
                    </div>
                @endif

                <!-- Header Card -->
                <div class="flex items-center space-x-3.5 mb-6 pb-5 border-b border-slate-100">
                    <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo DPUPR" class="w-12 h-12 object-contain flex-shrink-0 drop-shadow-xs">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight">Portal Masuk Pegawai</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Gunakan NIP (18 digit) atau Email dinas PUPR</p>
                    </div>
                </div>

                @if($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-circle-exclamation text-red-600 text-sm flex-shrink-0"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('sso.login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    @if($clientId)
                        <input type="hidden" name="client_id" value="{{ $clientId }}">
                        <input type="hidden" name="redirect_uri" value="{{ $redirectUri }}">
                        <input type="hidden" name="state" value="{{ $state }}">
                    @endif

                    <!-- Input NIP / Email -->
                    <div>
                        <label for="identifier" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            NIP / Email Dinas
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-id-badge text-sm"></i>
                            </div>
                            <input type="text"
                                   id="identifier"
                                   name="identifier"
                                   value="{{ old('identifier') }}"
                                   required
                                   placeholder="Contoh: 198501012010011001"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-pupr-deep focus:border-transparent text-sm font-medium text-slate-800 transition">
                        </div>
                    </div>

                    <!-- Input Password dengan Toggle Lihat Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   value=""
                                   required
                                   placeholder="Masukkan kata sandi"
                                   class="w-full pl-10 pr-11 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-pupr-deep focus:border-transparent text-sm font-medium text-slate-800 transition">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none" title="Lihat Kata Sandi">
                                <i id="password-toggle-icon" class="fa-solid fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center text-slate-600 select-none cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-pupr-deep border-slate-300 focus:ring-pupr-deep mr-2">
                            <span>Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full py-3 px-4 rounded-xl bg-pupr-deep hover:bg-slate-900 text-white font-extrabold text-sm shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center space-x-2">
                        <span>Masuk ke Portal SSO</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>

                    <!-- Divider -->
                    <div class="relative my-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs uppercase">
                            <span class="bg-white px-3 text-slate-400 font-bold text-[10px] tracking-widest">Atau masuk dengan</span>
                        </div>
                    </div>

                    <!-- Google SSO Button -->
                    <a href="{{ route('sso.google', request()->only(['client_id', 'redirect_uri', 'state'])) }}"
                       class="w-full py-2.5 px-4 rounded-xl border border-slate-300 hover:border-slate-400 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-xs hover:shadow transition flex items-center justify-center space-x-2.5">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.66v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.15z"/>
                            <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                            <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                            <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                        </svg>
                        <span>Masuk dengan Google SSO PUPR</span>
                    </a>
                </form>

                <!-- Footer Keamanan -->
                <div class="mt-5 pt-4 border-t border-slate-100 text-center text-[11px] text-slate-400 flex items-center justify-center space-x-1.5">
                    <i class="fa-solid fa-lock text-slate-300"></i>
                    <span>Dilindungi Enkripsi TLS 1.3 &bull; Keamanan Siber Pemkab Subang</span>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Bantuan Login & Reset Kata Sandi -->
<div id="modal-help" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-start justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-pupr-deep flex items-center justify-center font-bold">
                    <i class="fa-solid fa-headset text-lg"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Bantuan Akun SSO</h3>
                    <p class="text-xs text-slate-500">Dinas PUPR Kabupaten Subang</p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('modal-help').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="text-xs text-slate-600 space-y-3 leading-relaxed">
            <p>
                Untuk permohonan akun baru, pemulihan kata sandi, atau integrasi aplikasi sektoral dengan SSO, silakan hubungi:
            </p>
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-building text-pupr-deep w-4"></i>
                    <span class="font-semibold text-slate-800">Subbag Umum dan Kepegawaian</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-location-dot text-pupr-deep w-4"></i>
                    <span>Jl. Mayjen Sutoyo No. 1, Subang</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-envelope text-pupr-deep w-4"></i>
                    <span class="font-mono text-[11px]">kepegawaian@pupr.subang.go.id</span>
                </div>
            </div>
        </div>

        <button type="button" onclick="document.getElementById('modal-help').classList.add('hidden')" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
            Tutup
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePasswordVisibility() {
        const input = document.getElementById('password');
        const icon = document.getElementById('password-toggle-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
