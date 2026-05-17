<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Logging\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Provides audit logging capabilities for services and controllers.
 *
 * Writes immutable records to the audit_logs table capturing
 * who did what, when, and what changed. Audit logs are append-only
 * and must never be updated or deleted.
 */
trait HasAuditLog
{
    /**
     * Log an auditable action.
     *
     * @param  string  $action  Dot-notation action e.g. 'user.created', 'membership.revoked'
     * @param  Model|null  $resource  The affected resource model
     * @param  array  $oldValues  State before the action
     * @param  array  $newValues  State after the action
     * @param  array  $metadata  Additional structured context
     */
    protected function logAction(
        string $action,
        ?Model $resource = null,
        array $oldValues = [],
        array $newValues = [],
        array $metadata = [],
    ): void {
        AuditLog::create([
            'user_id' => Auth::id(),
            'corporation_id' => $this->resolveAuditCorporationId(),
            'action' => $action,
            'resource_type' => $resource ? get_class($resource) : null,
            'resource_id' => $resource?->id,
            'resource_uuid' => $resource?->uuid ?? null,
            'old_values' => ! empty($oldValues) ? $oldValues : null,
            'new_values' => ! empty($newValues) ? $newValues : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'metadata' => ! empty($metadata) ? $metadata : null,
        ]);
    }

    /**
     * Resolve the corporation ID for audit context.
     *
     * Checks the service container for a bound corporation,
     * falls back to null for platform-level actions.
     */
    private function resolveAuditCorporationId(): ?int
    {
        if (app()->bound('current.corporation')) {
            return app('current.corporation')->id;
        }

        return null;
    }
}
