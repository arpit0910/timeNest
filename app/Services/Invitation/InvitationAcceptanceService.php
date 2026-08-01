<?php

declare(strict_types=1);

namespace App\Services\Invitation;

use App\Actions\IssueJwtAction;
use App\Actions\Auth\SendEmailVerificationAction;
use App\Enums\AccountType;
use App\Enums\InvitationStatusEnum;
use App\Enums\UserStatus;
use App\Events\InvitationAccepted;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Auth\User;
use App\Models\Invitation\Invitation;
use App\Services\Organization\MembershipService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InvitationAcceptanceService
{
    public function __construct(
        private readonly MembershipService $membershipService,
        private readonly IssueJwtAction $issueJwtAction,
        private readonly SendEmailVerificationAction $sendEmailVerificationAction,
    ) {}

    /**
     * Accept an invitation using the raw token.
     */
    public function acceptInvitation(string $rawToken, array $profileData = []): array
    {
        $currentUser = auth()->user();
        if (! $currentUser && request()->bearerToken()) {
            try {
                $currentUser = \PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();
            } catch (\Exception) {
                // The public invitation flow permits an unauthenticated new user.
            }
        }

        $verificationToken = null;
        $result = DB::transaction(function () use ($rawToken, $profileData, $currentUser, &$verificationToken): array {
            $invitation = Invitation::where('token', hash('sha256', $rawToken))
                ->lockForUpdate()
                ->first();

            if (! $invitation) {
                throw new BusinessRuleViolationException('The invitation token is invalid.', 'INVALID_TOKEN');
            }

            if ($invitation->status !== InvitationStatusEnum::PENDING) {
                throw new BusinessRuleViolationException('Invitation is no longer valid.', 'INVITATION_ALREADY_PROCESSED');
            }

            if ($invitation->expires_at->isPast()) {
                $invitation->update(['status' => InvitationStatusEnum::EXPIRED]);
                throw new BusinessRuleViolationException('Invitation has expired.', 'INVITATION_EXPIRED');
            }

            $user = User::where('email', $invitation->email)->first();
            if ($user) {
                if (! $currentUser) {
                    throw new BusinessRuleViolationException('A user account with this email already exists. Please log in to accept the invitation.', 'AUTHENTICATION_REQUIRED');
                }
                if (strtolower($currentUser->email) !== strtolower($invitation->email)) {
                    throw new BusinessRuleViolationException('The authenticated user email does not match the invitation email.', 'EMAIL_MISMATCH');
                }
                $user = $currentUser;
            } else {
                if (empty($profileData['name']) || empty($profileData['password'])) {
                    throw new BusinessRuleViolationException('Profile name and password are required to accept the invitation and set up your account.', 'PROFILE_SETUP_REQUIRED');
                }

                $verificationToken = Str::random(64);
                $user = User::create([
                    'name' => $profileData['name'],
                    'first_name' => $profileData['first_name'] ?? null,
                    'last_name' => $profileData['last_name'] ?? null,
                    'email' => $invitation->email,
                    'password' => Hash::make($profileData['password']),
                    'password_set' => true,
                    'account_type' => AccountType::ORGANIZATION,
                    'email_verification_token' => hash('sha256', $verificationToken),
                    'email_verification_token_expires_at' => now()->addMinutes((int) config('timenest.verification.expire', 60)),
                    'is_active' => false,
                    'token_version' => 1,
                    'timezone' => $profileData['timezone'] ?? 'UTC',
                    'status' => UserStatus::PENDING_VERIFICATION,
                ]);
            }

            $isAlreadyMember = DB::table('organization_memberships')
                ->where('user_id', $user->id)
                ->where('organization_id', $invitation->organization_id)
                ->exists();

            if (! $isAlreadyMember) {
                $this->membershipService->addMember($invitation->organization, $user, $invitation->role, [], $invitation->invited_by_user_id);
            }

            $invitation->update(['status' => InvitationStatusEnum::ACCEPTED, 'accepted_at' => now()]);
            InvitationAccepted::dispatch($invitation);

            return [
                'status' => 'accepted',
                'message' => $verificationToken ? 'Invitation accepted. Please verify your email to sign in.' : 'Invitation accepted successfully.',
                'user' => $user,
                'organization' => $invitation->organization,
            ];
        });

        if ($verificationToken !== null) {
            $this->sendEmailVerificationAction->execute($result['user'], $verificationToken);
        }

        return $result;
    }
}
