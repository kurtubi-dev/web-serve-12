<?php

namespace Database\Seeders;

use App\Models\SsoAuditLog;
use App\Models\SsoClient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Seed the application's database with Dinas PUPR Kabupaten Subang data.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // 1. Seed Pegawai Dinas PUPR Subang
        $users = [
            [
                'name' => 'Administrator IT PUPR Subang',
                'nip' => '198501012010011001',
                'nik' => '3213010101850001',
                'email' => 'admin.it@pupr.subang.go.id',
                'phone_number' => '081234567890',
                'bidang' => 'Sekretariat',
                'seksi_subbag' => 'Subbagian Umum dan Kepegawaian',
                'jabatan' => 'Pranata Komputer Ahli Muda / Admin SSO',
                'pangkat_golongan' => 'Penata Muda Tk. I (III/b)',
                'status_kepegawaian' => 'PNS',
                'role' => 'superadmin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
            [
                'name' => 'Ir. H. Deden Hendrawan, M.Si.',
                'nip' => '197203151998031004',
                'nik' => '3213011503720002',
                'email' => 'kadis@pupr.subang.go.id',
                'phone_number' => '081399887766',
                'bidang' => 'Sekretariat',
                'seksi_subbag' => 'Pimpinan Dinas',
                'jabatan' => 'Kepala Dinas PUPR Kab. Subang',
                'pangkat_golongan' => 'Pembina Utama Muda (IV/c)',
                'status_kepegawaian' => 'PNS',
                'role' => 'superadmin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Fauzi, S.T., M.T.',
                'nip' => '197805202005011008',
                'nik' => '3213022005780003',
                'email' => 'kabid.binamarga@pupr.subang.go.id',
                'phone_number' => '081288776655',
                'bidang' => 'Bidang Bina Marga',
                'seksi_subbag' => 'Seksi Pembangunan Jalan dan Jembatan',
                'jabatan' => 'Kepala Bidang Bina Marga',
                'pangkat_golongan' => 'Pembina (IV/a)',
                'status_kepegawaian' => 'PNS',
                'role' => 'admin_bidang',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
            [
                'name' => 'Bambang Sudarmono, S.T.',
                'nip' => '198007122006041009',
                'nik' => '3213031207800004',
                'email' => 'kabid.sda@pupr.subang.go.id',
                'phone_number' => '081377665544',
                'bidang' => 'Bidang Sumber Daya Air (SDA)',
                'seksi_subbag' => 'Seksi Pembangunan Irigasi dan Sungai',
                'jabatan' => 'Kepala Bidang Sumber Daya Air',
                'pangkat_golongan' => 'Penata Tingkat I (III/d)',
                'status_kepegawaian' => 'PNS',
                'role' => 'admin_bidang',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
            [
                'name' => 'Siti Nurhaliza, S.T., M.Sc.',
                'nip' => '198209252008012015',
                'nik' => '3213042509820005',
                'email' => 'kabid.ciptakarya@pupr.subang.go.id',
                'phone_number' => '081266554433',
                'bidang' => 'Bidang Cipta Karya',
                'seksi_subbag' => 'Seksi Bangunan Gedung dan Lingkungan',
                'jabatan' => 'Kepala Bidang Cipta Karya',
                'pangkat_golongan' => 'Penata Tingkat I (III/d)',
                'status_kepegawaian' => 'PNS',
                'role' => 'admin_bidang',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
            [
                'name' => 'Rendi Pratama, S.T., M.P.W.K.',
                'nip' => '198304182009021003',
                'nik' => '3213051804830006',
                'email' => 'kabid.tataruang@pupr.subang.go.id',
                'phone_number' => '081355443322',
                'bidang' => 'Bidang Tata Ruang',
                'seksi_subbag' => 'Seksi Perencanaan dan Pengaturan Tata Ruang',
                'jabatan' => 'Kepala Bidang Penataan Ruang',
                'pangkat_golongan' => 'Penata (III/c)',
                'status_kepegawaian' => 'PNS',
                'role' => 'admin_bidang',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
            [
                'name' => 'Yudi Permana, S.T.',
                'nip' => '199208112019031006',
                'nik' => '3213061108920007',
                'email' => 'yudi.permana@pupr.subang.go.id',
                'phone_number' => '081244332211',
                'bidang' => 'Bidang Bina Marga',
                'seksi_subbag' => 'Seksi Pemeliharaan Jalan dan Jembatan',
                'jabatan' => 'Pengawas Teknis Jalan dan Jembatan Lapangan',
                'pangkat_golongan' => 'Penata Muda (III/a)',
                'status_kepegawaian' => 'PNS',
                'role' => 'pengawas_lapangan',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
            [
                'name' => 'Dewi Anggraeni, A.Md.',
                'nip' => '199611202022032008',
                'nik' => '3213072011960008',
                'email' => 'dewi.anggraeni@pupr.subang.go.id',
                'phone_number' => '081233221100',
                'bidang' => 'Sekretariat',
                'seksi_subbag' => 'Subbagian Keuangan dan Aset',
                'jabatan' => 'Pengelola Administrasi Keuangan Proyek',
                'pangkat_golongan' => 'Pengatur (II/c)',
                'status_kepegawaian' => 'PNS',
                'role' => 'pegawai',
                'password' => Hash::make('password'),
                'is_active' => true,
            ],
        ];

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // 2. Seed Client Apps (Aplikasi Terintegrasi Dinas PUPR Subang)
        $clients = [
            [
                'name' => 'SIM-JALAN Subang',
                'code_name' => 'sim-jalan',
                'client_id' => 'pupr_simjalan_subang_2026',
                'client_secret' => 'sec_simjalan_subang_9f83a48e71b29a10',
                'description' => 'Sistem Informasi Manajemen Kondisi Jalan, Jembatan & Pelaporan Kerusakan Infrastruktur Kabupaten Subang.',
                'app_url' => 'http://simjalan.pupr.subang.go.id',
                'redirect_uri' => 'http://simjalan.pupr.subang.go.id/auth/sso/callback,http://127.0.0.1:8001/auth/sso/callback',
                'bidang_terkait' => 'Bidang Bina Marga',
                'badge_color' => '#1E40AF',
                'icon_url' => 'road',
                'allowed_scopes' => ['profile', 'nip', 'bidang', 'jabatan'],
                'is_active' => true,
            ],
            [
                'name' => 'SI-IRIGASI SDA Subang',
                'code_name' => 'si-irigasi',
                'client_id' => 'pupr_siirigasi_subang_2026',
                'client_secret' => 'sec_siirigasi_subang_d83e7a12bc44e991',
                'description' => 'Sistem Informasi Pemantauan Jaringan Irigasi, Daerah Rawa, Debit Air dan Pintu Bendung Sumber Daya Air.',
                'app_url' => 'http://irigasi.pupr.subang.go.id',
                'redirect_uri' => 'http://irigasi.pupr.subang.go.id/auth/sso/callback,http://127.0.0.1:8002/auth/sso/callback',
                'bidang_terkait' => 'Bidang Sumber Daya Air (SDA)',
                'badge_color' => '#0284C7',
                'icon_url' => 'droplet',
                'allowed_scopes' => ['profile', 'nip', 'bidang'],
                'is_active' => true,
            ],
            [
                'name' => 'SIMBG Subang',
                'code_name' => 'simbg-subang',
                'client_id' => 'pupr_simbg_subang_2026',
                'client_secret' => 'sec_simbg_subang_77aa21c90ef43bb8',
                'description' => 'Sistem Informasi Manajemen Bangunan Gedung, Penerbitan PBG, dan Sertifikat Laik Fungsi (SLF) Cipta Karya.',
                'app_url' => 'http://simbg.pupr.subang.go.id',
                'redirect_uri' => 'http://simbg.pupr.subang.go.id/auth/sso/callback,http://127.0.0.1:8003/auth/sso/callback',
                'bidang_terkait' => 'Bidang Cipta Karya',
                'badge_color' => '#D97706',
                'icon_url' => 'building-2',
                'allowed_scopes' => ['profile', 'nip', 'bidang'],
                'is_active' => true,
            ],
            [
                'name' => 'SI-TARU Subang',
                'code_name' => 'si-taru',
                'client_id' => 'pupr_sitaru_subang_2026',
                'client_secret' => 'sec_sitaru_subang_38fa09de312988cb',
                'description' => 'Sistem Informasi Tata Ruang, Peta Pola Ruang RTRW / RDTR, dan Verifikasi Kesesuaian Tata Ruang (KKPR).',
                'app_url' => 'http://sitaru.pupr.subang.go.id',
                'redirect_uri' => 'http://sitaru.pupr.subang.go.id/auth/sso/callback,http://127.0.0.1:8004/auth/sso/callback',
                'bidang_terkait' => 'Bidang Tata Ruang',
                'badge_color' => '#059669',
                'icon_url' => 'map-pin',
                'allowed_scopes' => ['profile', 'nip', 'bidang'],
                'is_active' => true,
            ],
            [
                'name' => 'E-KINERJA PUPR Subang',
                'code_name' => 'e-kinerja',
                'client_id' => 'pupr_ekinerja_subang_2026',
                'client_secret' => 'sec_ekinerja_subang_a190ef22cd33bb41',
                'description' => 'Sistem Pengukuran Sasaran Kinerja Pegawai (SKP), Presensi Geotagging, dan Laporan Kinerja Bulanan ASN & THL.',
                'app_url' => 'http://ekinerja.pupr.subang.go.id',
                'redirect_uri' => 'http://ekinerja.pupr.subang.go.id/auth/sso/callback,http://127.0.0.1:8005/auth/sso/callback',
                'bidang_terkait' => 'Sekretariat',
                'badge_color' => '#7C3AED',
                'icon_url' => 'clipboard-check',
                'allowed_scopes' => ['profile', 'nip', 'bidang', 'pangkat_golongan'],
                'is_active' => true,
            ],
            [
                'name' => 'SIPJAKI Subang',
                'code_name' => 'sipjaki',
                'client_id' => 'pupr_sipjaki_subang_2026',
                'client_secret' => 'sec_sipjaki_subang_48ce01ba9942aef7',
                'description' => 'Sistem Informasi Pembina Jasa Konstruksi, Sertifikasi Tenaga Kerja Konstruksi, dan Pengawasan Mutu Proyek.',
                'app_url' => 'http://sipjaki.pupr.subang.go.id',
                'redirect_uri' => 'http://sipjaki.pupr.subang.go.id/auth/sso/callback,http://127.0.0.1:8006/auth/sso/callback',
                'bidang_terkait' => 'Bidang Jasa Konstruksi',
                'badge_color' => '#DC2626',
                'icon_url' => 'hard-hat',
                'allowed_scopes' => ['profile', 'nip', 'bidang'],
                'is_active' => true,
            ],
        ];

        foreach ($clients as $clientData) {
            SsoClient::updateOrCreate(
                ['client_id' => $clientData['client_id']],
                $clientData
            );
        }

        // 3. Catat initial audit log
        $admin = User::where('email', 'admin.it@pupr.subang.go.id')->first();
        if ($admin) {
            SsoAuditLog::create([
                'user_id' => $admin->id,
                'client_id' => 'pupr_central_system',
                'action' => 'SYSTEM_INIT',
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder Script',
                'details' => ['message' => 'SSO Web Service Dinas PUPR Kabupaten Subang successfully initialized'],
            ]);
        }
    }
}
