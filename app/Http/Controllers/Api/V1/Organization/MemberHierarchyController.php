<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\AssignDesignationRequest;
use App\Services\Organization\MemberHierarchyService;
use Illuminate\Http\JsonResponse;

class MemberHierarchyController extends Controller
{
    public function __construct(
        private readonly MemberHierarchyService $hierarchyService
    ) {}

    /**
     * Assign or remove a designation from a member.
     */
    public function assignDesignation(AssignDesignationRequest $request, string $memberUuid): JsonResponse
    {
        $organizationId = app('tenant.organization')->id;

        $member = $this->hierarchyService->assignDesignation(
            memberUuid: $memberUuid,
            designationUuid: $request->validated('designation_uuid'),
            organizationId: $organizationId,
        );

        return response()->json([
            'message' => $request->validated('designation_uuid')
                ? 'Designation assigned successfully.'
                : 'Designation removed successfully.',
            'data' => [
                'member_uuid'      => $member->uuid,
                'designation_uuid' => $member->designation?->uuid,
                'designation_name' => $member->designation?->name,
            ],
        ]);
    }

    /**
     * Resolve the full hierarchy chain for a member.
     */
    public function hierarchy(string $memberUuid): JsonResponse
    {
        $organizationId = app('tenant.organization')->id;

        $hierarchy = $this->hierarchyService->resolveHierarchy(
            memberUuid: $memberUuid,
            organizationId: $organizationId,
        );

        return response()->json(['data' => $hierarchy]);
    }
}
