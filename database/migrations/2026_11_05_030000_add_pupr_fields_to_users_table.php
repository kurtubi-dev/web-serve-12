<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip', 20)->nullable()->unique()->after('id');
            $table->string('nik', 20)->nullable()->after('nip');
            $table->string('phone_number', 25)->nullable()->after('email');
            $table->string('bidang', 100)->nullable()->after('phone_number'); // Bina Marga, SDA, Cipta Karya, Tata Ruang, Sekretariat, dll.
            $table->string('seksi_subbag', 150)->nullable()->after('bidang');
            $table->string('jabatan', 150)->nullable()->after('seksi_subbag');
            $table->string('pangkat_golongan', 50)->nullable()->after('jabatan'); // Pembina IV/a, Penata III/c, dll.
            $table->enum('status_kepegawaian', ['PNS', 'PPPK', 'Non-ASN / THL', 'Magang / Siswa'])->default('PNS')->after('pangkat_golongan');
            $table->enum('role', ['superadmin', 'admin_bidang', 'verifikator', 'pegawai', 'pengawas_lapangan'])->default('pegawai')->after('status_kepegawaian');
            $table->boolean('is_active')->default(true)->after('role');
            $table->string('avatar')->nullable()->after('is_active');
            $table->timestamp('last_login_at')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nip',
                'nik',
                'phone_number',
                'bidang',
                'seksi_subbag',
                'jabatan',
                'pangkat_golongan',
                'status_kepegawaian',
                'role',
                'is_active',
                'avatar',
                'last_login_at',
            ]);
        });
    }
};

