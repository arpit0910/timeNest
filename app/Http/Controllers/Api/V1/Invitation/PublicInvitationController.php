<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Invitation;

use App\Enums\InvitationStatusEnum;
use App\Exceptions\Business\BusinessRuleViolationException;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Invitation\AcceptInvitationRequest;
use App\Http\Resources\Auth\AuthTokenResource;
use App\Models\Auth\User;
use App\Models\Invitation\Invitation;
use App\Services\Invitation\InvitationAcceptanceService;
use Illuminate\Http\JsonResponse;

class PublicInvitationController extends BaseApiController
{
    public function __construct(
        private readonly InvitationAcceptanceService $acceptanceService
    ) {}

    /**
     * Validate an invitation token and return workspace metadata.
     */
    public function validateToken(string $token): JsonResponse
    {
        $hashedToken = hash('sha256', $token);

        $invitation = Invitation::where('token', $hashedToken)
            ->with(['organization', 'role'])
            ->first();

        if (!$invitation) {
            throw new BusinessRuleViolationException('The invitation token is invalid.', 'INVALID_TOKEN');
        }

        // Handle expired states
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

        $userExists = User::where('email', $invitation->email)->exists();

        return $this->success([
            'email' => $invitation->email,
            'user_exists' => $userExists,
            'expires_at' => $invitation->expires_at->toISOString(),
            'organization' => [
                'uuid' => $invitation->organization->uuid,
                'legal_name' => $invitation->organization->legal_name,
                'trading_name' => $invitation->organization->trading_name,
                'slug' => $invitation->organization->slug,
                'logo_url' => $invitation->organization->logo_url,
            ],
            'role' => [
                'uuid' => $invitation->role->uuid,
                'name' => $invitation->role->name,
                'description' => $invitation->role->description,
            ],
        ]);
    }

    /**
     * Accept the invitation (onboard user and/or login).
     */
    public function accept(AcceptInvitationRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $token = $validated['token'];

        // Filter out token to keep only profileData
        unset($validated['token']);

        $result = $this->acceptanceService->acceptInvitation($token, $validated);

        if (isset($result['access_token'])) {
            return $this->success(
                data: new AuthTokenResource($result),
                message: $result['message'] ?? 'Invitation accepted and logged in successfully.'
            );
        }

        return $this->success(
            data: [
                'status' => $result['status'],
                'user' => [
                    'uuid' => $result['user']->uuid,
                    'name' => $result['user']->name,
                    'email' => $result['user']->email,
                ],
                'organization' => [
                    'uuid' => $result['organization']->uuid,
                    'legal_name' => $result['organization']->legal_name,
                ],
            ],
            message: $result['message']
        );
    }
}
