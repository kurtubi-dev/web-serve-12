@extends('layouts.app')

@section('title', 'Pilih Akun - Google SSO PUPR Subang')

@section('content')
<div class="w-full max-w-lg mx-auto py-10 px-4 sm:px-6">

    <!-- Card Google Account Chooser -->
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden">
        
        <!-- Header: Google & Subang SSO Identity -->
        <div class="p-6 sm:p-8 pb-5 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <!-- Google Badge -->
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-slate-100/90 border border-slate-200 text-xs font-semibold text-slate-700">
                    <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.8-2.4 3.66v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.15z"/>
                        <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                        <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                        <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                    </svg>
                    <span>Login dengan Google SSO</span>
                </div>

                <!-- DPUPR Logo -->
                <img src="{{ asset('images/logo-pupr.png') }}" alt="Logo PUPR" class="w-8 h-8 object-contain">
            </div>

            <h1 class="text-2xl font-bold text-slate-900 mt-4 tracking-tight">Pilih akun</h1>
            <p class="text-xs text-slate-500 mt-1">
                Pilih akun Google Anda untuk melanjutkan ke <strong class="text-slate-800">Dinas PUPR Kabupaten Subang</strong>
            </p>
        </div>

        @if(session('error'))
            <div class="mx-6 sm:mx-8 mt-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-2 text-rose-600"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- List Akun -->
        <div class="divide-y divide-slate-100">
            @php
                $bgColors = ['bg-blue-600', 'bg-emerald-600', 'bg-amber-500', 'bg-indigo-600', 'bg-rose-600', 'bg-cyan-600'];
            @endphp

            @foreach($availableUsers as $index => $pegawai)
                <form action="{{ route('sso.google.simulate') }}" method="POST" class="m-0">
                    @csrf
                    <input type="hidden" name="email" value="{{ $pegawai->email }}">
                    <button type="submit" class="w-full text-left px-6 sm:px-8 py-3.5 hover:bg-slate-50 transition flex items-center space-x-3.5 group cursor-pointer">
                        <!-- Avatar -->
                        @if($pegawai->avatar)
                            <img src="{{ $pegawai->avatar }}" alt="{{ $pegawai->name }}" class="w-10 h-10 rounded-full object-cover shadow-2xs border border-slate-200 group-hover:scale-105 transition-transform">
                        @else
                            <div class="w-10 h-10 rounded-full {{ $bgColors[$index % count($bgColors)] }} text-white font-bold text-sm flex items-center justify-center flex-shrink-0 shadow-2xs group-hover:scale-105 transition-transform">
                                {{ strtoupper(substr($pegawai->name, 0, 1)) }}
                            </div>
                        @endif

                        <!-- Identity Info -->
                        <div class="flex-grow min-w-0">
                            <div class="text-xs font-bold text-slate-900 group-hover:text-blue-700 truncate transition-colors">
                                {{ $pegawai->name }}
                            </div>
                            <div class="text-[11px] text-slate-500 truncate">
                                {{ $pegawai->email }}
                            </div>
                            <div class="text-[10px] text-slate-400 truncate">
                                {{ $pegawai->jabatan ?? 'Pegawai ASN' }}
                            </div>
                        </div>

                        <!-- Arrow Indicator -->
                        <div class="text-slate-300 group-hover:text-blue-600 group-hover:translate-x-0.5 transition flex-shrink-0">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </div>
                    </button>
                </form>
            @endforeach

            <!-- Option: Gunakan Akun Lain (Google Style) -->
            <div>
                <button type="button" 
                        id="toggleOtherAccountBtn"
                        onclick="toggleOtherAccountForm()"
                        class="w-full text-left px-6 sm:px-8 py-4 hover:bg-slate-50 transition flex items-center space-x-3.5 group cursor-pointer">
                    <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 text-slate-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-50 group-hover:text-blue-600 group-hover:border-blue-200 transition">
                        <i class="fa-solid fa-user-plus text-xs"></i>
                    </div>
                    <div class="flex-grow">
                        <div class="text-xs font-bold text-slate-800 group-hover:text-blue-700 transition">
                            Gunakan akun lain
                        </div>
                        <div class="text-[11px] text-slate-400">
                            Masuk dengan email Google atau dinas Anda
                        </div>
                    </div>
                    <div class="text-slate-300 group-hover:text-blue-600 group-hover:translate-x-0.5 transition flex-shrink-0">
                        <i class="fa-solid fa-chevron-right text-xs" id="otherAccountChevron"></i>
                    </div>
                </button>

                <!-- Input Box Tersembunyi (Expandable) -->
                <div id="otherAccountContainer" class="hidden px-6 sm:px-8 py-4 bg-slate-50/80 border-t border-slate-100">
                    <form action="{{ route('sso.google.simulate') }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label for="custom_email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Email Google Pribadi / Dinas:
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-envelope text-xs"></i>
                                </div>
                                <input type="email"
                                       id="custom_email"
                                       name="email"
                                       required
                                       placeholder="contoh: nama@gmail.com"
                                       class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-blue-600 focus:border-transparent focus:outline-none transition">
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-2 pt-1">
                            <button type="button" 
                                    onclick="toggleOtherAccountForm()"
                                    class="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 rounded-xl hover:bg-slate-200/80 transition">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-slate-900 hover:bg-blue-950 text-white rounded-xl text-xs font-bold shadow-xs hover:shadow transition flex items-center space-x-1.5">
                                <span>Lanjutkan</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="px-6 sm:px-8 py-4 bg-slate-50/60 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
            <span class="inline-flex items-center">
                <i class="fa-solid fa-shield-halved mr-1.5 text-emerald-600"></i>
                SSO Terenkripsi TLS 1.3
            </span>
            <a href="{{ route('sso.login') }}" class="font-semibold text-slate-600 hover:text-pupr-deep transition inline-flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left text-[10px] mr-1"></i>
                <span>Kembali ke Login</span>
            </a>
        </div>

    </div>

    <!-- Bottom Secondary Info -->
    <div class="mt-6 text-center text-xs text-slate-400 flex items-center justify-center space-x-3">
        <span>Bahasa Indonesia</span>
        <span>&bull;</span>
        <a href="{{ route('sso.docs') }}" class="hover:text-slate-600 transition">Bantuan & Dokumentasi</a>
        <span>&bull;</span>
        <a href="{{ route('sso.login') }}" class="hover:text-slate-600 transition">Portal NIP</a>
    </div>

</div>

<script>
    function toggleOtherAccountForm() {
        const container = document.getElementById('otherAccountContainer');
        const chevron = document.getElementById('otherAccountChevron');
        const emailInput = document.getElementById('custom_email');

        if (container.classList.contains('hidden')) {
            container.classList.remove('hidden');
            if (chevron) {
                chevron.classList.add('rotate-90');
            }
            if (emailInput) {
                setTimeout(() => emailInput.focus(), 50);
            }
        } else {
            container.classList.add('hidden');
            if (chevron) {
                chevron.classList.remove('rotate-90');
            }
        }
    }
</script>
@endsection
