<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\UpdateEmployeeProfileRequest;
use App\Http\Resources\Organization\EmployeeProfileResource;
use App\Models\Membership\EmployeeProfile;
use App\Services\Organization\MembershipService;
use Illuminate\Http\JsonResponse;

class EmployeeProfileController extends Controller
{
    public function __construct(
        private readonly MembershipService $membershipService
    ) {}

    /**
     * View an employee profile by membership UUID.
     * Scoped to the current organization.
     */
    public function show(string $membershipUuid): JsonResponse
    {
        $organizationId = app('tenant.organization')->id;

        $profile = EmployeeProfile::where('organization_id', $organizationId)
            ->whereHas('membership', fn($q) => $q->where('uuid', $membershipUuid))
            ->with([
                'user',
                'membership',
                'designation.subDepartment.department',
                'department',
                'branch',
                'reportsTo',
            ])
            ->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data' => new EmployeeProfileResource($profile),
        ]);
    }

    /**
     * Update an employee profile by membership UUID.
     * Delegates entirely to MembershipService::updateEmployeeProfile().
     */
    public function update(UpdateEmployeeProfileRequest $request, string $membershipUuid): JsonResponse
    {
        $organizationId = app('tenant.organization')->id;

        $profile = EmployeeProfile::where('organization_id', $organizationId)
            ->whereHas('membership', fn($q) => $q->where('uuid', $membershipUuid))
            ->firstOrFail();

        $updated = $this->membershipService->updateEmployeeProfile(
            $profile,
            $request->validated(),
        );

        return response()->json([
            'status' => 'success',
            'data' => new EmployeeProfileResource(
                $updated->load(['user', 'designation.subDepartment.department', 'department', 'branch', 'reportsTo'])
            ),
        ]);
    }
}
