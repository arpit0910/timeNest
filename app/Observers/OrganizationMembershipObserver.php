<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\MembershipStatus;
use App\Enums\NotificationTypeEnum;
use App\Models\Organization\OrganizationMembership;

/**
 * Tells people when their place in an organization changes — joining, leaving,
 * or being moved to a different team.
 */
class OrganizationMembershipObserver
{
    public function created(OrganizationMembership $membership): void
    {
        $organizationName = $membership->organization?->trading_name
            ?? $membership->organization?->legal_name
            ?? 'the organization';

        notify_user($membership->user_id, NotificationTypeEnum::MEMBER_ADDED, [
            'body' => "You were added to {$organizationName}.",
            'organization_id' => $membership->organization_id,
            'action_url' => '/(tabs)',
            'subject' => $membership,
            'actor' => $membership->invited_by !== null ? (int) $membership->invited_by : auth()->id(),
        ]);
    }

    public function updated(OrganizationMembership $membership): void
    {
        $actorId = auth()->id();

        if ($membership->isDirty('status')) {
            $status = $membership->status instanceof \BackedEnum
                ? $membership->status->value
                : $membership->status;

            // Removal suspends the membership rather than deleting it, so the
            // row and its history survive; REVOKED/LEFT are the other exits.
            $exitStatuses = [
                MembershipStatus::SUSPENDED->value,
                MembershipStatus::REVOKED->value,
                MembershipStatus::LEFT->value,
            ];

            if (in_array($status, $exitStatuses, true)) {
                $organizationName = $membership->organization?->trading_name
                    ?? $membership->organization?->legal_name
                    ?? 'the organization';

                notify_user($membership->user_id, NotificationTypeEnum::MEMBER_REMOVED, [
                    'body' => "Your access to {$organizationName} was removed.",
                    'organization_id' => $membership->organization_id,
                    'subject' => $membership,
                    'actor' => $actorId,
                ]);
            }
        }

        if ($membership->isDirty('designation_id') && $membership->designation_id !== null) {
            $designation = $membership->designation?->name;

            notify_user($membership->user_id, NotificationTypeEnum::DESIGNATION_ASSIGNED, [
                'body' => $designation
                    ? "Your designation is now {$designation}."
                    : 'Your designation was updated.',
                'organization_id' => $membership->organization_id,
                'subject' => $membership,
                'actor' => $actorId,
            ]);
        }
    }
}
