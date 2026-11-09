<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SsoClient extends Model
{
    use HasFactory;

    protected $table = 'sso_clients';

    protected $fillable = [
        'client_id',
        'client_secret',
        'name',
        'code_name',
        'description',
        'app_url',
        'redirect_uri',
        'icon_url',
        'badge_color',
        'bidang_terkait',
        'allowed_scopes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'allowed_scopes' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Generate new client credentials
     */
    public static function generateCredentials(string $codeName): array
    {
        return [
            'client_id' => 'pupr_' . Str::slug($codeName, '_') . '_' . Str::lower(Str::random(12)),
            'client_secret' => 'sec_' . Str::random(40),
        ];
    }

    /**
     * Check if given secret matches this client
     */
    public function verifySecret(string $secret): bool
    {
        return hash_equals($this->client_secret, $secret);
    }

    /**
     * Verify if redirect URI matches allowed redirect URI
     */
    public function matchesRedirectUri(string $uri): bool
    {
        $allowed = array_map('trim', explode(',', $this->redirect_uri));
        foreach ($allowed as $allowedUri) {
            if (str_starts_with($uri, $allowedUri)) {
                return true;
            }
        }
        return false;
    }

    public function authCodes(): HasMany
    {
        return $this->hasMany(SsoAuthCode::class, 'client_id', 'client_id');
    }
}

