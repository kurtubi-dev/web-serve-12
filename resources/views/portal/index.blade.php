@extends('layouts.app')

@section('title', 'Portal Layanan Terpadu &mdash; Politeknik')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- Student Identity Header -->
        <div class="bg-white rounded-xl border border-slate-200/90 p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start sm:items-center space-x-4">
                <img src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0f172a&color=fff&bold=true' }}"
                    alt="{{ $user->name }}"
                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0f172a&color=fff&bold=true';"
                    class="w-16 h-16 rounded-md border border-slate-300 object-cover bg-slate-100 flex-shrink-0">
                <div class="space-y-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $user->name }}</h1>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            SSO TERVERIFIKASI
                        </span>
                    </div>
                    <div class="text-xs text-slate-600">
                        Program Studi: <strong class="text-slate-800">Teknik Informatika</strong> &bull; Semester Ganjil 2026/2027
                    </div>
                </div>
            </div>

            <!-- Time & Session Metadata -->
            <div class="flex sm:flex-col items-start sm:items-end justify-between border-t sm:border-t-0 pt-4 sm:pt-0 border-slate-100 text-xs">
                <div class="text-[11px] text-slate-400 font-mono">SESI DIAUTENTIKASI:</div>
                <div class="font-mono font-bold text-slate-800">{{ now()->format('d M Y, H:i') }} WIB</div>
                <div class="text-[11px] text-emerald-700 font-medium mt-1">
                    <i class="fa-solid fa-circle-check text-[10px] mr-1"></i> Akses Lintas Layanan Terbuka
                </div>
            </div>
        </div>

        <!-- 3 Primary Campus Services -->
        <div>
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-slate-500">Layanan Akademik</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- 1. Portal Akademik (SIAKAD) -->
                <div class="bg-white rounded-xl border border-slate-200/90 p-5 flex flex-col justify-between hover:border-indigo-400 transition-colors shadow-2xs group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-9 h-9 rounded-md bg-indigo-50 text-indigo-800 flex items-center justify-center text-sm font-bold border border-indigo-100">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </span>
                            <span class="text-[10px] font-mono font-semibold uppercase text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                SIAKAD
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-900 transition-colors">Portal Akademik</h3>
                        <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">
                            Kartu Rencana Studi (KRS), perolehan nilai hasil studi (KHS), transkrip nilai terverifikasi, dan jadwal kuliah tatap muka.
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('services.akademik') }}"
                            class="w-full inline-flex items-center justify-center space-x-2 px-4 py-2.5 rounded-md bg-[#0f172a] hover:bg-indigo-900 text-white font-semibold text-xs transition-colors">
                            <span>Buka Portal Akademik</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- 2. E-Learning (LMS) -->
                <div class="bg-white rounded-xl border border-slate-200/90 p-5 flex flex-col justify-between hover:border-emerald-400 transition-colors shadow-2xs group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-9 h-9 rounded-md bg-emerald-50 text-emerald-800 flex items-center justify-center text-sm font-bold border border-emerald-100">
                                <i class="fa-solid fa-laptop-code"></i>
                            </span>
                            <span class="text-[10px] font-mono font-semibold uppercase text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                LMS KAMPUS
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-emerald-900 transition-colors">E-Learning</h3>
                        <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">
                            Ruang perkuliahan daring, materi kuliah digital, tugas praktikum mingguan, dan forum diskusi interaktif dosen-mahasiswa.
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('services.elearning') }}"
                            class="w-full inline-flex items-center justify-center space-x-2 px-4 py-2.5 rounded-md bg-[#0f172a] hover:bg-emerald-900 text-white font-semibold text-xs transition-colors">
                            <span>Buka E-Learning</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- 3. Perpustakaan Digital (DigiLib) -->
                <div class="bg-white rounded-xl border border-slate-200/90 p-5 flex flex-col justify-between hover:border-amber-400 transition-colors shadow-2xs group">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-9 h-9 rounded-md bg-amber-50 text-amber-800 flex items-center justify-center text-sm font-bold border border-amber-100">
                                <i class="fa-solid fa-book-bookmark"></i>
                            </span>
                            <span class="text-[10px] font-mono font-semibold uppercase text-slate-500 bg-slate-100 px-2 py-0.5 rounded">
                                DIGILIB
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-amber-900 transition-colors">Perpustakaan Digital</h3>
                        <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">
                            Pencarian katalog pustaka fisik, perpanjangan masa pinjam mandiri, akses koleksi jurnal bereputasi, dan e-book repository.
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('services.perpustakaan') }}"
                            class="w-full inline-flex items-center justify-center space-x-2 px-4 py-2.5 rounded-md bg-[#0f172a] hover:bg-amber-900 text-white font-semibold text-xs transition-colors">
                            <span>Buka Perpustakaan Digital</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
