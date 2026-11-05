@extends('layouts.app')

@section('title', 'Portal Akademik (SIAKAD) &mdash; Layanan Kampus')

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
                    <span class="text-slate-900 font-bold">Portal Akademik</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Sistem Informasi Akademik</h1>
            </div>
        </div>

        <!-- SSO Verification Status Strip -->
        <div class="p-3.5 rounded-md bg-indigo-50/70 border border-indigo-200/90 text-xs text-indigo-950 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-indigo-700"></i>
                <span><strong>Bukti Pengujian SSO:</strong> Halaman Akademik ini terbuka langsung tanpa login ulang karena sesi tersinkronisasi via Google IdP.</span>
            </div>
            <span class="font-mono text-[10px] bg-indigo-100 text-indigo-900 px-2 py-0.5 rounded font-bold uppercase whitespace-nowrap">
                OIDC Session Valid
            </span>
        </div>

        <!-- Academic Key Metrics -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200/90 shadow-2xs">
                <div class="text-[10px] font-mono text-slate-400 uppercase font-bold">IPK Kumulatif</div>
                <div class="text-2xl font-black text-slate-900 font-mono mt-1">3.85</div>
                <div class="text-[11px] text-slate-500 mt-0.5 font-mono">Skala 4.00</div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200/90 shadow-2xs">
                <div class="text-[10px] font-mono text-slate-400 uppercase font-bold">SKS Semester Ini</div>
                <div class="text-2xl font-black text-slate-900 font-mono mt-1">18 SKS</div>
                <div class="text-[11px] text-slate-500 mt-0.5 font-mono">Beban Maksimal: 24 SKS</div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200/90 shadow-2xs">
                <div class="text-[10px] font-mono text-slate-400 uppercase font-bold">Tahun Akademik</div>
                <div class="text-base font-bold text-slate-900 mt-1">Ganjil 2026/2027</div>
                <div class="text-[11px] text-emerald-700 font-semibold mt-0.5">KRS Disetujui Dosen Wali</div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200/90 shadow-2xs">
                <div class="text-[10px] font-mono text-slate-400 uppercase font-bold">Tingkat Kehadiran</div>
                <div class="text-2xl font-black text-emerald-700 font-mono mt-1">96.4%</div>
            </div>
        </div>

        <!-- Jadwal Kuliah & KHS -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- Jadwal Kuliah -->
            <div class="lg:col-span-7 bg-white rounded-xl border border-slate-200/90 p-5 shadow-2xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h2 class="text-sm font-bold text-slate-900">Jadwal Kuliah Semester Ini</h2>
                    <span class="text-[11px] font-mono text-slate-500">4 Kelas Teori & Praktikum</span>
                </div>

                <div class="divide-y divide-slate-100 text-xs">
                    @foreach($jadwalKuliah as $jadwal)
                    <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-100 text-slate-800">{{ $jadwal['hari'] }}</span>
                                <span class="font-mono text-slate-500 text-[11px]">{{ $jadwal['jam'] }}</span>
                                <span class="text-slate-400">&bull; {{ $jadwal['sks'] }} SKS</span>
                            </div>
                            <div class="text-sm font-bold text-slate-900">{{ $jadwal['matkul'] }}</div>
                            <div class="text-slate-500 text-[11px]">{{ $jadwal['dosen'] }}</div>
                        </div>
                        <div class="sm:text-right">
                            <span class="inline-block px-2.5 py-1 rounded bg-slate-50 border border-slate-200 text-slate-700 font-mono text-[11px]">
                                {{ $jadwal['ruangan'] }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Kartu Hasil Studi (KHS) -->
            <div class="lg:col-span-5 bg-white rounded-xl border border-slate-200/90 p-5 shadow-2xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h2 class="text-sm font-bold text-slate-900">Kartu Hasil Studi Terakhir</h2>
                    <span class="text-[11px] font-mono text-emerald-800 font-semibold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">IPS: 3.85</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-[10px] font-mono text-slate-400 uppercase border-b border-slate-100 pb-2">
                                <th class="pb-2 font-semibold">Mata Kuliah</th>
                                <th class="pb-2 text-center font-semibold">SKS</th>
                                <th class="pb-2 text-center font-semibold">Nilai</th>
                                <th class="pb-2 text-right font-semibold">Bobot</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($khs as $item)
                            <tr>
                                <td class="py-2.5">
                                    <div class="font-bold text-slate-900">{{ $item['matkul'] }}</div>
                                    <div class="text-[10px] font-mono text-slate-400">{{ $item['kode'] }}</div>
                                </td>
                                <td class="py-2.5 text-center font-mono text-slate-600">{{ $item['sks'] }}</td>
                                <td class="py-2.5 text-center">
                                    <span class="font-mono font-bold text-slate-900 bg-slate-100 px-1.5 py-0.5 rounded text-[11px]">
                                        {{ $item['nilai'] }}
                                    </span>
                                </td>
                                <td class="py-2.5 text-right font-mono font-bold text-slate-900">{{ number_format($item['bobot'], 1) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-mono">
                    <span>Predikat Akademik:</span>
                    <span class="font-bold text-slate-900">Dengan Pujian</span>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
