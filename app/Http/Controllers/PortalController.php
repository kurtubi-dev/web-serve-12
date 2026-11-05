<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    /**
     * Portal Utama Layanan Kampus (Dashboard Hub)
     */
    public function index()
    {
        $user = Auth::user();

        $services = [
            [
                'id' => 'akademik',
                'name' => 'Portal Akademik (SIAKAD)',
                'category' => 'Administrasi & Nilai',
                'description' => 'Akses Kartu Rencana Studi (KRS), Kartu Hasil Studi (KHS), Transkrip Nilai, dan Jadwal Perkuliahan.',
                'route' => 'services.akademik',
                'icon' => 'academic-cap',
                'badge' => 'Semester Ganjil 2026/2027',
                'color' => 'indigo',
                'stats' => 'IPK: 3.85 | 18 SKS Aktif',
            ],
            [
                'id' => 'elearning',
                'name' => 'E-Learning (LMS Kampus)',
                'category' => 'Pembelajaran Online',
                'description' => 'Akses modul materi kuliah daring, kuis interaktif, pengumpulan tugas, dan forum diskusi dosen-mahasiswa.',
                'route' => 'services.elearning',
                'icon' => 'book-open',
                'badge' => '3 Tugas Menunggu',
                'color' => 'emerald',
                'stats' => '6 Kelas Aktif | Progress 84%',
            ],
            [
                'id' => 'perpustakaan',
                'name' => 'Perpustakaan Digital (DigiLib)',
                'category' => 'Pustaka & Referensi',
                'description' => 'Pencarian katalog koleksi buku fisik, peminjaman mandiri, jurnal internasional, dan pembaca e-book online.',
                'route' => 'services.perpustakaan',
                'icon' => 'library',
                'badge' => '2 Buku Dipinjam',
                'color' => 'amber',
                'stats' => 'Bebas Pustaka: Aktif',
            ],
        ];

        return view('portal.index', compact('user', 'services'));
    }

    /**
     * Modul Layanan Akademik
     */
    public function akademik()
    {
        $user = Auth::user();

        $jadwalKuliah = [
            ['hari' => 'Senin', 'jam' => '08:00 - 10:30', 'matkul' => 'Arsitektur Web Service & API', 'dosen' => 'Dr. Hendra Wijaya, M.T.', 'ruangan' => 'Lab Komputer 3', 'sks' => 3],
            ['hari' => 'Senin', 'jam' => '13:00 - 15:30', 'matkul' => 'Keamanan Sistem Informasi & SSO', 'dosen' => 'Prof. Ir. Siti Rahmawati, Ph.D.', 'ruangan' => 'Lab Cyber Security', 'sks' => 3],
            ['hari' => 'Rabu', 'jam' => '09:00 - 11:30', 'matkul' => 'Rekayasa Perangkat Lunak Lanjut', 'dosen' => 'Ahmad Fauzi, M.Kom.', 'ruangan' => 'Gedung TI R.204', 'sks' => 3],
            ['hari' => 'Kamis', 'jam' => '10:00 - 12:30', 'matkul' => 'Cloud Computing & Microservices', 'dosen' => 'Dewi Lestari, M.T.', 'ruangan' => 'Lab Cloud 1', 'sks' => 3],
        ];

        $khs = [
            ['kode' => 'TI-401', 'matkul' => 'Web Service & API Integration', 'sks' => 3, 'nilai' => 'A', 'bobot' => 4.0],
            ['kode' => 'TI-402', 'matkul' => 'Keamanan Informasi & SSO', 'sks' => 3, 'nilai' => 'A-', 'bobot' => 3.7],
            ['kode' => 'TI-403', 'matkul' => 'Pemrograman Berorientasi Objek Lanjut', 'sks' => 3, 'nilai' => 'A', 'bobot' => 4.0],
            ['kode' => 'TI-404', 'matkul' => 'Basis Data Terdistribusi', 'sks' => 3, 'nilai' => 'B+', 'bobot' => 3.3],
        ];

        return view('services.akademik', compact('user', 'jadwalKuliah', 'khs'));
    }

    /**
     * Modul Layanan E-Learning
     */
    public function elearning()
    {
        $user = Auth::user();

        $courses = [
            [
                'title' => 'Web Service & Single Sign-On (SSO)',
                'code' => 'WS-2026',
                'lecturer' => 'Dr. Hendra Wijaya, M.T.',
                'progress' => 88,
                'current_topic' => 'Pertemuan 8: Arsitektur OAuth 2.0 & Socialite IDP',
                'tasks_due' => 'Tugas 4: Implementasi SSO Multi-Service',
                'deadline' => 'Besok, 23:59 WIB',
            ],
            [
                'title' => 'Keamanan Sistem Komputer',
                'code' => 'SEC-2026',
                'lecturer' => 'Prof. Ir. Siti Rahmawati, Ph.D.',
                'progress' => 75,
                'current_topic' => 'Pertemuan 7: Federated Identity & SAML / OpenID Connect',
                'tasks_due' => 'Analisis Studi Kasus Serangan Man-in-the-Middle',
                'deadline' => '3 hari lagi',
            ],
            [
                'title' => 'Cloud Computing & DevOps',
                'code' => 'CC-2026',
                'lecturer' => 'Dewi Lestari, M.T.',
                'progress' => 92,
                'current_topic' => 'Pertemuan 9: Containerization & Reverse Proxy Nginx',
                'tasks_due' => 'Praktikum Docker Compose',
                'deadline' => 'Selesai diserahkan',
            ],
        ];

        return view('services.elearning', compact('user', 'courses'));
    }

    /**
     * Modul Layanan Perpustakaan Digital
     */
    public function perpustakaan()
    {
        $user = Auth::user();

        $pinjaman = [
            [
                'judul' => 'Mastering API Architecture & OAuth 2.0',
                'penulis' => 'James Higginbotham',
                'tgl_pinjam' => '20 Oktober 2026',
                'tgl_kembali' => '3 November 2026',
                'sisa_hari' => '5 Hari Lagi',
                'status' => 'Sedang Dipinjam',
            ],
            [
                'judul' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'penulis' => 'Robert C. Martin',
                'tgl_pinjam' => '22 Oktober 2026',
                'tgl_kembali' => '5 November 2026',
                'sisa_hari' => '7 Hari Lagi',
                'status' => 'Sedang Dipinjam',
            ],
        ];

        $katalogBuku = [
            ['judul' => 'Building Secure and Reliable Systems', 'kategori' => 'Keamanan', 'penulis' => 'Heather Adkins dkk.', 'penerbit' => "O'Reilly Media", 'tersedia' => 4],
            ['judul' => 'Designing Data-Intensive Applications', 'kategori' => 'Database & Backend', 'penulis' => 'Martin Kleppmann', 'penerbit' => "O'Reilly Media", 'tersedia' => 2],
            ['judul' => 'Microservice Architecture & REST API', 'kategori' => 'Web Service', 'penulis' => 'Sam Newman', 'penerbit' => "Packt Publishing", 'tersedia' => 6],
            ['judul' => 'Laravel Up & Running (3rd Edition)', 'kategori' => 'Framework', 'penulis' => 'Matt Stauffer', 'penerbit' => "O'Reilly Media", 'tersedia' => 3],
        ];

        return view('services.perpustakaan', compact('user', 'pinjaman', 'katalogBuku'));
    }
}

