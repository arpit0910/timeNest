<?php

declare(strict_types=1);

namespace App\Services\Leave;

use App\Exceptions\Leave\CannotDeleteSystemLeaveTypeException;
use App\Exceptions\Leave\LeaveTypeCodeAlreadyExistsException;
use App\Exceptions\Leave\LeaveTypeNotFoundException;
use App\Models\Auth\User;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeaveType;
use App\Models\Organization\Organization;
use Illuminate\Support\Collection;

class LeaveTypeService
{
    /**
     * Create a new leave type for a policy.
     *
     * @param LeavePolicy $policy
     * @param array $data
     * @param User $createdBy
     * @return LeaveType
     */
    public function createType(LeavePolicy $policy, array $data, User $createdBy): LeaveType
    {
        $code = strtoupper($data['code']);

        if (LeaveType::where('organization_id', $policy->organization_id)
            ->where('code', $code)
            ->exists()) {
            throw new LeaveTypeCodeAlreadyExistsException();
        }

        $data['code'] = $code;
        $data['organization_id'] = $policy->organization_id;
        $data['leave_policy_id'] = $policy->id;
        $data['created_by'] = $createdBy->id;
        $data['updated_by'] = $createdBy->id;

        return LeaveType::create($data);
    }

    /**
     * Update an existing leave type.
     *
     * @param LeaveType $leaveType
     * @param array $data
     * @param User $updatedBy
     * @return LeaveType
     */
    public function updateType(LeaveType $leaveType, array $data, User $updatedBy): LeaveType
    {
        if (isset($data['code'])) {
            $code = strtoupper($data['code']);
            
            $exists = LeaveType::where('organization_id', $leaveType->organization_id)
                ->where('code', $code)
                ->where('id', '!=', $leaveType->id)
                ->exists();

            if ($exists) {
                throw new LeaveTypeCodeAlreadyExistsException();
            }

            $data['code'] = $code;
        }

        $data['updated_by'] = $updatedBy->id;
        $leaveType->update($data);

        return $leaveType->fresh();
    }

    /**
     * Deactivate a leave type.
     *
     * @param LeaveType $leaveType
     * @param User $updatedBy
     * @return LeaveType
     */
    public function deactivateType(LeaveType $leaveType, User $updatedBy): LeaveType
    {
        $leaveType->update([
            'is_active' => false,
            'updated_by' => $updatedBy->id,
        ]);

        return $leaveType;
    }

    /**
     * Soft delete a leave type.
     *
     * @param LeaveType $leaveType
     * @return void
     */
    public function deleteType(LeaveType $leaveType): void
    {
        if ($leaveType->is_system_type) {
            throw new CannotDeleteSystemLeaveTypeException();
        }

        $leaveType->delete();
    }

    /**
     * Get all leave types for a policy.
     *
     * @param LeavePolicy $policy
     * @param bool $includeInactive
     * @return Collection
     */
    public function getTypesForPolicy(LeavePolicy $policy, bool $includeInactive = false): Collection
    {
        $query = LeaveType::where('leave_policy_id', $policy->id)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc');

        if (!$includeInactive) {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    /**
     * Get a leave type by UUID for a given organization.
     *
     * @param string $uuid
     * @param Organization $organization
     * @return LeaveType
     */
    public function getTypeByUuid(string $uuid, Organization $organization): LeaveType
    {
        $leaveType = LeaveType::where('uuid', $uuid)
            ->where('organization_id', $organization->id)
            ->first();

        if (!$leaveType) {
            throw new LeaveTypeNotFoundException();
        }

        return $leaveType;
    }
}
