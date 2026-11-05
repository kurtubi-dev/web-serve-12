@extends('layouts.app')

@section('title', 'Perpustakaan Digital (DigiLib) &mdash; Layanan Kampus')

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
                    <span class="text-slate-900 font-bold">Perpustakaan Digital (DigiLib)</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Perpustakaan Digital</h1>
            </div>
        </div>

        <!-- SSO Verification Status Strip -->
        <div class="p-3.5 rounded-md bg-amber-50/70 border border-amber-200/90 text-xs text-amber-950 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-amber-700"></i>
                <span><strong>Bukti Pengujian SSO:</strong> Layanan Perpustakaan Digital memvalidasi keanggotaan secara otomatis dari sesi SSO terpusat.</span>
            </div>
            <span class="font-mono text-[10px] bg-amber-100 text-amber-900 px-2 py-0.5 rounded font-bold uppercase whitespace-nowrap">
                OIDC Session Valid
            </span>
        </div>

        <!-- Loan Summary Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- Pinjaman Aktif -->
            <div class="lg:col-span-6 bg-white rounded-xl border border-slate-200/90 p-5 shadow-2xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h2 class="text-sm font-bold text-slate-900">Buku yang Sedang Dipinjam</h2>
                    <span class="text-[11px] font-mono text-slate-500">2 Koleksi Aktif</span>
                </div>

                <div class="space-y-3 text-xs">
                    @foreach($pinjaman as $item)
                    <div class="p-3.5 rounded-lg border border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <span class="font-mono text-[10px] font-bold text-emerald-800 bg-emerald-100 px-1.5 py-0.5 rounded">
                                {{ $item['status'] }}
                            </span>
                            <div class="font-bold text-slate-900 text-sm mt-1">{{ $item['judul'] }}</div>
                            <div class="text-[11px] text-slate-500">{{ $item['penulis'] }}</div>
                            <div class="text-[10px] font-mono text-slate-500 pt-1">
                                Tanggal Pinjam: {{ $item['tgl_pinjam'] }} &bull; Batas: <span class="font-semibold text-rose-600">{{ $item['tgl_kembali'] }}</span>
                            </div>
                        </div>
                        <div class="sm:text-right">
                            <span class="inline-block px-2.5 py-1 rounded bg-white text-slate-800 font-mono text-[11px] font-bold border border-slate-200">
                                {{ $item['sisa_hari'] }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Koleksi Katalog Terpopuler -->
            <div class="lg:col-span-6 bg-white rounded-xl border border-slate-200/90 p-5 shadow-2xs space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h2 class="text-sm font-bold text-slate-900">Koleksi Buku Referensi Terpopuler</h2>
                    <span class="text-[11px] font-mono text-slate-500">Katalog Pustaka</span>
                </div>

                <div class="space-y-2.5 text-xs">
                    @foreach($katalogBuku as $buku)
                    <div class="p-3 rounded-lg border border-slate-200 hover:border-slate-400 bg-white transition-colors flex items-center justify-between">
                        <div class="space-y-0.5">
                            <span class="font-mono text-[10px] uppercase font-bold text-slate-400">{{ $buku['kategori'] }}</span>
                            <div class="font-bold text-slate-900 text-xs">{{ $buku['judul'] }}</div>
                            <div class="text-[11px] text-slate-500">{{ $buku['penulis'] }} &bull; <span class="text-slate-400">{{ $buku['penerbit'] }}</span></div>
                        </div>
                        <div class="text-right">
                            <span class="font-mono text-[11px] font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                {{ $buku['tersedia'] }} Eks
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
