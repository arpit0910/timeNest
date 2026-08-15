<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\NotificationTypeEnum;
use App\Events\InvitationAccepted;
use App\Events\InvitationRevoked;
use App\Models\Auth\User;

/**
 * In-app counterpart to the invitation emails.
 *
 * A pending invitation has no account to address yet, so only acceptance and
 * revocation raise notifications — and they go to the person who sent the
 * invite, who is the one waiting on the outcome.
 */
class SendInvitationInAppNotification
{
    public function handleAccepted(InvitationAccepted $event): void
    {
        $invitation = $event->invitation;

        if ($invitation->invited_by_user_id === null) {
            return;
        }

        $accepter = User::where('email', $invitation->email)->value('name') ?? $invitation->email;

        notify_user($invitation->invited_by_user_id, NotificationTypeEnum::INVITATION_ACCEPTED, [
            'body' => "{$accepter} accepted your invitation and joined the organization.",
            'organization_id' => $invitation->organization_id,
            'action_url' => '/members',
            'subject' => $invitation,
        ]);
    }

    public function handleRevoked(InvitationRevoked $event): void
    {
        $invitation = $event->invitation;

        if ($invitation->invited_by_user_id === null) {
            return;
        }

        notify_user($invitation->invited_by_user_id, NotificationTypeEnum::INVITATION_REVOKED, [
            'body' => "The invitation for {$invitation->email} was revoked.",
            'organization_id' => $invitation->organization_id,
            'action_url' => "/invitations/{$invitation->uuid}",
            'subject' => $invitation,
            'actor' => auth()->id(),
        ]);
    }
}
