<?php

declare(strict_types=1);

namespace App\Services\Invitation;

use App\Actions\IssueJwtAction;
use App\Enums\Guard;
use App\Enums\InvitationStatusEnum;
use App\Events\InvitationAccepted;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Auth\User;
use App\Models\Invitation\Invitation;
use App\Services\Corporation\MembershipService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InvitationAcceptanceService
{
    public function __construct(
        private readonly MembershipService $membershipService,
        private readonly IssueJwtAction $issueJwtAction
    ) {}

    /**
     * Accept an invitation using the raw token.
     */
    public function acceptInvitation(string $rawToken, array $profileData = []): array
    {
        $hashedToken = hash('sha256', $rawToken);

        $invitation = Invitation::where('token', $hashedToken)->first();

        if (!$invitation) {
            throw new BusinessRuleViolationException('The invitation token is invalid.', 'INVALID_TOKEN');
        }

        // Handle expired invitations
        if ($invitation->isExpired()) {
            if ($invitation->status === InvitationStatusEnum::Pending) {
                $invitation->update(['status' => InvitationStatusEnum::Expired]);
            }
            throw new BusinessRuleViolationException('This invitation has expired.', 'EXPIRED_TOKEN');
        }

        if ($invitation->status === InvitationStatusEnum::Revoked) {
            throw new BusinessRuleViolationException('This invitation has been revoked.', 'REVOKED_TOKEN');
        }

        if ($invitation->status === InvitationStatusEnum::Accepted) {
            throw new BusinessRuleViolationException('This invitation has already been accepted.', 'ACCEPTED_TOKEN');
        }

        $existingUser = User::where('email', $invitation->email)->first();

        // Flow for existing user
        if ($existingUser) {
            $currentUser = auth()->user();

            if (!$currentUser) {
                throw new BusinessRuleViolationException(
                    'A user account with this email already exists. Please log in to accept the invitation.',
                    'AUTHENTICATION_REQUIRED'
                );
            }

            if (strtolower($currentUser->email) !== strtolower($invitation->email)) {
                throw new BusinessRuleViolationException(
                    'The authenticated user email does not match the invitation email.',
                    'EMAIL_MISMATCH'
                );
            }

            // Check if user is already a member of this corporation
            $isAlreadyMember = DB::table('corp_memberships')
                ->where('user_id', $currentUser->id)
                ->where('corporation_id', $invitation->corporation_id)
                ->exists();

            if ($isAlreadyMember) {
                // If they are already a member, we just mark the invitation accepted
                DB::transaction(function () use ($invitation) {
                    $invitation->update([
                        'status' => InvitationStatusEnum::Accepted,
                        'accepted_at' => now(),
                    ]);
                    InvitationAccepted::dispatch($invitation);
                });

                return [
                    'status' => 'accepted',
                    'message' => 'You are already a member of this corporation.',
                    'user' => $currentUser,
                    'corporation' => $invitation->corporation,
                ];
            }

            return DB::transaction(function () use ($invitation, $currentUser) {
                // Attach to corporation
                $this->membershipService->addMember(
                    $invitation->corporation,
                    $currentUser,
                    $invitation->role,
                    [],
                    $invitation->invited_by_user_id
                );

                $invitation->update([
                    'status' => InvitationStatusEnum::Accepted,
                    'accepted_at' => now(),
                ]);

                InvitationAccepted::dispatch($invitation);

                // For existing users already logged in, we return success.
                // If they want corporate tokens, they switch workspace or select corporation.
                return [
                    'status' => 'accepted',
                    'message' => 'Invitation accepted successfully.',
                    'user' => $currentUser,
                    'corporation' => $invitation->corporation,
                ];
            });
        }

        // Flow for new user
        if (empty($profileData['name']) || empty($profileData['password'])) {
            throw new BusinessRuleViolationException(
                'Profile name and password are required to accept the invitation and set up your account.',
                'PROFILE_SETUP_REQUIRED'
            );
        }

        return DB::transaction(function () use ($invitation, $profileData) {
            // 1. Create the new user
            $user = User::create([
                'name' => $profileData['name'],
                'first_name' => $profileData['first_name'] ?? null,
                'last_name' => $profileData['last_name'] ?? null,
                'email' => $invitation->email,
                'password' => Hash::make($profileData['password']),
                'password_set' => true,
                'email_verified_at' => now(), // pre-verified
                'is_active' => true,
                'token_version' => 1,
                'timezone' => $profileData['timezone'] ?? 'UTC',
            ]);

            // 2. Attach to corporation
            $this->membershipService->addMember(
                $invitation->corporation,
                $user,
                $invitation->role,
                [],
                $invitation->invited_by_user_id
            );

            // 3. Update invitation status
            $invitation->update([
                'status' => InvitationStatusEnum::Accepted,
                'accepted_at' => now(),
            ]);

            InvitationAccepted::dispatch($invitation);

            // 4. Generate JWT tokens for immediate login
            $roleName = $invitation->role->name;
            $accessToken = $this->issueJwtAction->issueAccessToken($user, $invitation->corporation, Guard::Corp, $roleName);
            $refreshToken = $this->issueJwtAction->issueRefreshToken($user, $invitation->corporation, Guard::Corp);

            return [
                'status' => 'accepted',
                'message' => 'Invitation accepted and account registered successfully.',
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
                'user' => $user,
                'corporation' => $invitation->corporation,
                'role' => $roleName,
            ];
        });
    }
}
