<?php

declare(strict_types=1);

namespace App\Models\Logging;

use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * AuditLog — immutable, append-only audit trail.
 *
 * No updated_at. No soft deletes. Never update or delete audit logs.
 *
 * @property int $id
 * @property string $uuid
 * @property string $action
 * @property Carbon $created_at
 */
class AuditLog extends Model
{
    use HasUuid;

    protected $table = 'audit_logs';

    /** @var bool Disable updated_at — append-only table */
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id', 'organization_id', 'action',
        'resource_type', 'resource_id', 'resource_uuid',
        'old_values', 'new_values',
        'ip_address', 'user_agent', 'metadata',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function scopeForOrganization($query, int $orgId)
    {
        return $query->where('organization_id', $orgId);
    }

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }
}
