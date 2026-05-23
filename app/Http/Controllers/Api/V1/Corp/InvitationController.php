<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Corp;

use App\Exceptions\Business\BusinessRuleViolationException;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Invitation\StoreInvitationRequest;
use App\Http\Resources\Invitation\InvitationResource;
use App\Models\Corporation\Corporation;
use App\Models\Invitation\Invitation;
use App\Models\Rbac\Role;
use App\Services\Invitation\InvitationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvitationController extends BaseApiController
{
    public function __construct(
        private readonly InvitationService $invitationService
    ) {}

    /**
     * Resolve the active corporation from the container.
     */
    private function tenant(): Corporation
    {
        return app('tenant.corporation');
    }

    /**
     * List invitations for the current corporation.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Invitation::where('corporation_id', $this->tenant()->id)
            ->with(['role', 'invitedBy', 'revokedBy']);

        // Search by email
        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', (int) $request->input('status'));
        }

        $invitations = $query->orderBy('created_at', 'desc')->paginate(50);

        return $this->success(InvitationResource::collection($invitations)->response()->getData(true));
    }

    /**
     * Show a specific invitation.
     */
    public function show(string $uuid): JsonResponse
    {
        $invitation = Invitation::where('uuid', $uuid)
            ->where('corporation_id', $this->tenant()->id)
            ->firstOrFail();

        return $this->success(new InvitationResource($invitation));
    }

    /**
     * Create an invitation.
     */
    public function store(StoreInvitationRequest $request): JsonResponse
    {
        $role = Role::where('uuid', $request->input('role_uuid'))->firstOrFail();

        $invitation = $this->invitationService->createInvitation(
            $this->tenant(),
            $request->input('email'),
            (int) $role->id,
            auth()->user(),
            $request->input('metadata') ?? []
        );

        return $this->created(
            new InvitationResource($invitation),
            'Invitation created and sent successfully.'
        );
    }

    /**
     * Revoke an active invitation.
     */
    public function revoke(string $uuid): JsonResponse
    {
        $invitation = Invitation::where('uuid', $uuid)
            ->where('corporation_id', $this->tenant()->id)
            ->firstOrFail();

        $revoked = $this->invitationService->revokeInvitation($invitation, auth()->user());

        return $this->success(
            new InvitationResource($revoked),
            'Invitation revoked successfully.'
        );
    }

    /**
     * Resend a pending invitation.
     */
    public function resend(string $uuid): JsonResponse
    {
        $invitation = Invitation::where('uuid', $uuid)
            ->where('corporation_id', $this->tenant()->id)
            ->firstOrFail();

        $resent = $this->invitationService->resendInvitation($invitation, auth()->user());

        return $this->success(
            new InvitationResource($resent),
            'Invitation resent successfully.'
        );
    }
}
