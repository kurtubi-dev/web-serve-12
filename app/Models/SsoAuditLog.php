<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class SsoAuditLog extends Model
{
    use HasFactory;

    protected $table = 'sso_audit_logs';

    protected $fillable = [
        'user_id',
        'client_id',
        'action',
        'ip_address',
        'user_agent',
        'details',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
        ];
    }

    /**
     * Helper cepat untuk mencatat aktivitas SSO
     */
    public static function record(?int $userId, string $action, ?string $clientId = null, ?Request $request = null, ?array $details = null): self
    {
        return self::create([
            'user_id' => $userId,
            'client_id' => $clientId,
            'action' => $action,
            'ip_address' => $request?->ip() ?? request()?->ip(),
            'user_agent' => $request?->userAgent() ?? request()?->userAgent(),
            'details' => $details,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

