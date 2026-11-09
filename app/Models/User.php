<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
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
        'password',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relasi ke auth codes
     */
    public function authCodes(): HasMany
    {
        return $this->hasMany(SsoAuthCode::class);
    }

    /**
     * Relasi ke audit logs
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(SsoAuditLog::class);
    }

    /**
     * Check if user is Super Admin Dinas PUPR Subang
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * Payload data profil yang diekspos ke client SSO
     */
    public function toSsoPayload(): array
    {
        return [
            'id' => $this->id,
            'nip' => $this->nip,
            'nik' => $this->nik,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'bidang' => $this->bidang,
            'seksi_subbag' => $this->seksi_subbag,
            'jabatan' => $this->jabatan,
            'pangkat_golongan' => $this->pangkat_golongan,
            'status_kepegawaian' => $this->status_kepegawaian,
            'role' => $this->role,
            'is_active' => $this->is_active,
            'instansi' => 'Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Subang',
            'instansi_kode' => 'PUPR-SUBANG',
        ];
    }
}
