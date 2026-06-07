<?php

declare(strict_types=1);

namespace App\Services\Invitation;

use App\Enums\InvitationStatusEnum;
use App\Events\InvitationCreated;
use App\Events\InvitationRevoked;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Auth\User;
use App\Models\Organization\Organization;
use App\Models\Invitation\Invitation;
use App\Models\Rbac\Role;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvitationService
{
    /**
     * Create a new invitation.
     */
    public function createInvitation(
        Organization $organization,
        string $email,
        int $roleId,
        User $invitedByUser,
        array $metadata = []
    ): Invitation {
        // 1. Verify role belongs to this organization (or is a valid system org role)
        $role = Role::findOrFail($roleId);
        if ($role->organization_id !== null && (int) $role->organization_id !== $organization->id) {
            throw new BusinessRuleViolationException('The selected role is not valid for this organization.', 'INVALID_ROLE');
        }
        if ($role->organization_id === null) {
            $systemRole = \App\Enums\SystemRole::tryFrom($role->name);
            if (!$systemRole || !$systemRole->isOrganizationRole()) {
                throw new BusinessRuleViolationException('Platform roles cannot be assigned to organization members.', 'INVALID_ROLE');
            }
        }

        // 2. Prevent duplicate active invitations for the same email inside the same organization
        $existing = Invitation::where('organization_id', $organization->id)
            ->where('email', $email)
            ->where('status', InvitationStatusEnum::Pending)
            ->where('expires_at', '>', now())
            ->first();

        if ($existing) {
            throw new BusinessRuleViolationException('An active invitation already exists for this email address.', 'DUPLICATE_INVITATION');
        }

        // 3. Generate raw token and secure hash
        $rawToken = Str::random(40);
        $hashedToken = hash('sha256', $rawToken);

        return DB::transaction(function () use ($organization, $email, $roleId, $invitedByUser, $hashedToken, $rawToken, $metadata) {
            $invitation = Invitation::create([
                'organization_id' => $organization->id,
                'email' => $email,
                'role_id' => $roleId,
                'invited_by_user_id' => $invitedByUser->id,
                'token' => $hashedToken,
                'status' => InvitationStatusEnum::Pending,
                'expires_at' => now()->addDays(7),
                'resend_count' => 0,
                'metadata' => $metadata,
            ]);

            // Dispatch created event
            InvitationCreated::dispatch($invitation, $rawToken);

            return $invitation;
        });
    }

    /**
     * Revoke an active invitation.
     */
    public function revokeInvitation(Invitation $invitation, User $revokedByUser): Invitation
    {
        if ($invitation->status !== InvitationStatusEnum::Pending) {
            throw new BusinessRuleViolationException('Only pending invitations can be revoked.', 'INVALID_STATE');
        }

        DB::transaction(function () use ($invitation, $revokedByUser) {
            $invitation->update([
                'status' => InvitationStatusEnum::Revoked,
                'revoked_at' => now(),
                'revoked_by' => $revokedByUser->id,
            ]);

            InvitationRevoked::dispatch($invitation);
        });

        return $invitation;
    }

    /**
     * Resend a pending invitation (regenerate token and extend expiry).
     */
    public function resendInvitation(Invitation $invitation, User $resentByUser): Invitation
    {
        if ($invitation->status !== InvitationStatusEnum::Pending) {
            throw new BusinessRuleViolationException('Only pending invitations can be resent.', 'INVALID_STATE');
        }

        // Generate new raw token and secure hash
        $rawToken = Str::random(40);
        $hashedToken = hash('sha256', $rawToken);

        DB::transaction(function () use ($invitation, $hashedToken, $rawToken) {
            $invitation->update([
                'token' => $hashedToken,
                'expires_at' => now()->addDays(7),
                'resend_count' => $invitation->resend_count + 1,
                'last_resent_at' => now(),
            ]);

            InvitationCreated::dispatch($invitation, $rawToken);
        });

        return $invitation;
    }
}
