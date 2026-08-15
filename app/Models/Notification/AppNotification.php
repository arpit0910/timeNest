<?php

declare(strict_types=1);

namespace App\Models\Notification;

use App\Enums\NotificationPriorityEnum;
use App\Enums\NotificationTypeEnum;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AppNotification extends Model
{
    use HasUuid;

    protected $table = 'app_notifications';

    protected $fillable = [
        'user_id',
        'organization_id',
        'type',
        'category',
        'priority',
        'title',
        'body',
        'action_url',
        'subject_type',
        'subject_id',
        'data',
        'actor_id',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => NotificationTypeEnum::class,
            'priority' => NotificationPriorityEnum::class,
            'data' => 'array',
            'read_at' => 'datetime',
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

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead(Builder $query): Builder
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Rows visible while the given workspace is active: that org's rows plus
     * the org-less account/security ones, which follow the user everywhere.
     */
    public function scopeForOrganization(Builder $query, ?int $organizationId): Builder
    {
        if ($organizationId === null) {
            return $query->whereNull('organization_id');
        }

        return $query->where(function (Builder $q) use ($organizationId): void {
            $q->where('organization_id', $organizationId)
                ->orWhereNull('organization_id');
        });
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    /** No-op when already read, so re-marking never rewrites the timestamp. */
    public function markAsRead(): bool
    {
        if ($this->read_at !== null) {
            return false;
        }

        $this->forceFill(['read_at' => now()])->save();

        return true;
    }

    public function markAsUnread(): bool
    {
        if ($this->read_at === null) {
            return false;
        }

        $this->forceFill(['read_at' => null])->save();

        return true;
    }
}
