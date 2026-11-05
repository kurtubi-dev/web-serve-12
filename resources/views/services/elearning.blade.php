@extends('layouts.app')

@section('title', 'E-Learning (LMS) &mdash; Layanan Kampus')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-200">
            <div>
                <div class="flex items-center space-x-2 text-xs text-slate-500 font-mono">
                    <a href="{{ route('portal') }}" class="hover:text-slate-900 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i> Portal Utama
                    </a>
                    <span>/</span>
                    <span class="text-slate-900 font-bold">E-Learning</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Learning Management System</h1>
            </div>
        </div>

        <!-- SSO Verification Status Strip -->
        <div class="p-3.5 rounded-md bg-emerald-50/70 border border-emerald-200/90 text-xs text-emerald-950 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-emerald-700"></i>
                <span><strong>Bukti Pengujian SSO:</strong> Sesi LMS aktif otomatis tanpa meminta login ulang saat berpindah dari portal atau modul akademik.</span>
            </div>
            <span class="font-mono text-[10px] bg-emerald-100 text-emerald-900 px-2 py-0.5 rounded font-bold uppercase whitespace-nowrap">
                OIDC Session Valid
            </span>
        </div>

        <!-- Courses List -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-900">Mata Kuliah Daring yang Sedang Berjalan</h2>
                <span class="text-xs font-mono text-slate-500">6 Kelas Terdaftar Aktif</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($courses as $course)
                <div class="bg-white rounded-xl border border-slate-200/90 p-5 shadow-2xs flex flex-col justify-between hover:border-slate-400 transition-colors">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-mono text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">{{ $course['code'] }}</span>
                            <span class="font-mono text-xs font-bold text-slate-900">{{ $course['progress'] }}% Selesai</span>
                        </div>

                        <h3 class="text-base font-bold text-slate-900 leading-snug">{{ $course['title'] }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $course['lecturer'] }}</p>

                        <!-- Progress Bar -->
                        <div class="w-full bg-slate-100 rounded-full h-1.5 my-4">
                            <div class="bg-[#0f172a] h-1.5 rounded-full" style="width: {{ $course['progress'] }}%"></div>
                        </div>

                        <div class="p-3 rounded-lg bg-slate-50 border border-slate-100 text-xs space-y-1.5 font-mono">
                            <div class="text-[10px] uppercase text-slate-400 font-sans">Topik Terkini:</div>
                            <div class="font-sans font-medium text-slate-800 text-xs">{{ $course['current_topic'] }}</div>
                            <div class="pt-2 border-t border-slate-200/70 flex items-center justify-between text-[11px]">
                                <span class="text-slate-500 font-sans">Tenggat Tugas:</span>
                                <span class="font-bold text-rose-600">{{ $course['deadline'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="button" class="w-full py-2.5 rounded-md bg-slate-100 hover:bg-[#0f172a] hover:text-white text-slate-700 font-semibold text-xs border border-slate-200 transition-colors">
                            Buka Modul Perkuliahan
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
