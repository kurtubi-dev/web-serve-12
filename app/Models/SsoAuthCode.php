<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SsoAuthCode extends Model
{
    use HasFactory;

    protected $table = 'sso_auth_codes';

    protected $fillable = [
        'code',
        'client_id',
        'user_id',
        'redirect_uri',
        'scopes',
        'expires_at',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'scopes' => 'array',
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    /**
     * Buat Authorization Code baru
     */
    public static function createCode(string $clientId, int $userId, string $redirectUri, ?array $scopes = null, int $ttlMinutes = 5): self
    {
        return self::create([
            'code' => Str::random(64),
            'client_id' => $clientId,
            'user_id' => $userId,
            'redirect_uri' => $redirectUri,
            'scopes' => $scopes ?? ['profile', 'nip', 'bidang'],
            'expires_at' => Carbon::now()->addMinutes($ttlMinutes),
        ]);
    }

    /**
     * Cek apakah kode masih valid dan belum expired
     */
    public function isValid(): bool
    {
        return is_null($this->used_at) && $this->expires_at->isFuture();
    }

    /**
     * Tandai kode telah ditukar / digunakan
     */
    public function markAsUsed(): void
    {
        $this->update(['used_at' => Carbon::now()]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(SsoClient::class, 'client_id', 'client_id');
    }
}

