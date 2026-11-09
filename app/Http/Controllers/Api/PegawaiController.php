<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Daftar Bidang resmi di Dinas PUPR Kabupaten Subang
     */
    public const BIDANG_LIST = [
        'Sekretariat' => [
            'Subbagian Perencanaan dan Program',
            'Subbagian Keuangan dan Aset',
            'Subbagian Umum dan Kepegawaian',
        ],
        'Bidang Bina Marga' => [
            'Seksi Pembangunan Jalan dan Jembatan',
            'Seksi Pemeliharaan Jalan dan Jembatan',
        ],
        'Bidang Sumber Daya Air (SDA)' => [
            'Seksi Pembangunan Irigasi dan Sungai',
            'Seksi Operasi dan Pemeliharaan Sumber Daya Air',
        ],
        'Bidang Cipta Karya' => [
            'Seksi Bangunan Gedung dan Lingkungan',
            'Seksi Penyehatan Lingkungan Permukiman dan Air Minum',
        ],
        'Bidang Tata Ruang' => [
            'Seksi Perencanaan dan Pengaturan Tata Ruang',
            'Seksi Pemanfaatan dan Pengendalian Tata Ruang',
        ],
        'Bidang Jasa Konstruksi' => [
            'Seksi Bina Kelembagaan dan Jasa Konstruksi',
            'Seksi Pengawasan Mutu Konstruksi',
        ],
        'UPTD Pengelolaan Jalan dan Irigasi' => [
            'UPTD Wilayah Subang Kota',
            'UPTD Wilayah Pamanukan / Pantura',
            'UPTD Wilayah Pagaden',
            'UPTD Wilayah Jalancagak / Selatan',
        ],
    ];

    /**
     * Endpoint: GET /api/v1/sso/pegawai
     * Mengambil daftar pegawai dengan filter pencarian dan bidang
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::query()->where('is_active', true);

        // Filter berdasarkan bidang
        if ($request->filled('bidang')) {
            $query->where('bidang', 'like', '%' . $request->input('bidang') . '%');
        }

        // Filter berdasarkan status kepegawaian (PNS, PPPK, Non-ASN)
        if ($request->filled('status')) {
            $query->where('status_kepegawaian', $request->input('status'));
        }

        // Pencarian teks (Nama, NIP, Jabatan)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 15);
        $pegawai = $query->orderBy('name', 'asc')->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'instansi' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Subang',
            'data' => $pegawai->items(),
            'pagination' => [
                'total' => $pegawai->total(),
                'per_page' => $pegawai->perPage(),
                'current_page' => $pegawai->currentPage(),
                'last_page' => $pegawai->lastPage(),
            ],
        ]);
    }

    /**
     * Endpoint: GET /api/v1/sso/pegawai/{nip}
     * Detail pegawai berdasarkan NIP
     */
    public function show(string $nip): JsonResponse
    {
        $pegawai = User::where('nip', $nip)
            ->orWhere('id', $nip)
            ->first();

        if (! $pegawai) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pegawai dengan NIP/ID tersebut tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pegawai->toSsoPayload(),
        ]);
    }

    /**
     * Endpoint: GET /api/v1/sso/bidang-list
     * Struktur organisasi bidang dan seksi di Dinas PUPR Subang
     */
    public function listBidang(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'instansi' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Subang',
            'bidang' => self::BIDANG_LIST,
        ]);
    }
}

