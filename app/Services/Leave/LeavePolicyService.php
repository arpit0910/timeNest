<?php

declare(strict_types=1);

namespace App\Services\Leave;

use App\Enums\Leave\ApprovalFlow;
use App\Exceptions\Leave\LeavePolicyAlreadyExistsException;
use App\Exceptions\Leave\LeavePolicyNotFoundException;
use App\Models\Auth\User;
use App\Models\Leave\LeavePolicy;
use App\Models\Leave\LeavePolicyVersion;
use App\Models\Leave\LeaveType;
use App\Models\Organization\Organization;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LeavePolicyService
{
    /**
     * Get the org's leave policy, auto-provisioning a default policy + a
     * minimal default LeaveType set on first-ever use if none exists yet.
     * Defaults per docs/LEAVE_MODULE_REPORT.md section 7.
     */
    public function getOrCreatePolicy(Organization $organization, User $createdBy): LeavePolicy
    {
        return DB::transaction(function () use ($organization, $createdBy) {
            $policy = LeavePolicy::firstOrCreate([
                'organization_id' => $organization->id,
            ], [
                'approval_flow' => ApprovalFlow::SINGLE_APPROVAL->value,
                'allow_leave_cancellation' => true,
                'cancellation_before_hours' => 24,
                'negative_balance_allowed' => false,
                'advance_notice_required_days' => 1,
                'max_advance_application_days' => 90,
                'document_required_after_days' => 3,
                'created_by' => $createdBy->id,
                'updated_by' => $createdBy->id,
            ]);

            if ($policy->wasRecentlyCreated) {
                $policy->refresh();
                $this->createVersionSnapshot($policy, 1, $createdBy);
                $this->seedDefaultLeaveTypes($policy, $createdBy);
            }

            return $policy;
        });
    }

    /**
     * Default leave types created alongside an auto-provisioned policy.
     * Codes map to App\Enums\Leave\LeaveType (CASUAL=1, SICK=2, PAID=3, UNPAID=4)
     * since LeaveRequestService::submitLeave() resolves that enum via
     * (int) $leaveType->code. Verified directly against the enum source —
     * an earlier version of this list used a stale doc's mapping and got
     * Unpaid Leave's code wrong (had it as 6, which is actually EXTRA_WORKING_DAY).
     *
     * Allocation days (12/12/15/0) are a standard-practice placeholder, not an
     * org-specific HR decision — flagged for review, not verified against any
     * real policy. Unpaid Leave is exempted from balance tracking entirely
     * (counts_towards_balance = false) since it isn't a balance concept — it
     * should always be submittable regardless of allocation/negative_balance_allowed.
     */
    private function seedDefaultLeaveTypes(LeavePolicy $policy, User $createdBy): void
    {
        $defaults = [
            ['code' => '1', 'name' => 'Casual Leave', 'annual_allocation_days' => 12, 'counts_towards_balance' => true],
            ['code' => '2', 'name' => 'Sick Leave', 'annual_allocation_days' => 12, 'counts_towards_balance' => true],
            ['code' => '3', 'name' => 'Paid Leave', 'annual_allocation_days' => 15, 'counts_towards_balance' => true],
            ['code' => '4', 'name' => 'Unpaid Leave', 'annual_allocation_days' => 0, 'counts_towards_balance' => false],
        ];

        foreach ($defaults as $default) {
            LeaveType::create([
                'organization_id' => $policy->organization_id,
                'leave_policy_id' => $policy->id,
                'name' => $default['name'],
                'code' => $default['code'],
                'annual_allocation_days' => $default['annual_allocation_days'],
                'counts_towards_balance' => $default['counts_towards_balance'],
                'is_system_type' => true,
                'created_by' => $createdBy->id,
                'updated_by' => $createdBy->id,
            ]);
        }
    }

    /**
     * Create a new leave policy for the given organization.
     *
     * @param Organization $organization
     * @param array $data
     * @param User $createdBy
     * @return LeavePolicy
     */
    public function createPolicy(Organization $organization, array $data, User $createdBy): LeavePolicy
    {
        if (LeavePolicy::where('organization_id', $organization->id)->exists()) {
            throw new LeavePolicyAlreadyExistsException();
        }

        return DB::transaction(function () use ($organization, $data, $createdBy) {
            $data['organization_id'] = $organization->id;
            $data['created_by'] = $createdBy->id;
            $data['updated_by'] = $createdBy->id;

            $policy = LeavePolicy::create($data);
            $policy->refresh();

            $this->createVersionSnapshot($policy, 1, $createdBy);

            return $policy->load(['versions', 'leaveTypes.organization', 'leaveTypes.policy']);
        });
    }

    /**
     * Update an existing leave policy.
     *
     * @param LeavePolicy $policy
     * @param array $data
     * @param User $updatedBy
     * @return LeavePolicy
     */
    public function updatePolicy(LeavePolicy $policy, array $data, User $updatedBy): LeavePolicy
    {
        return DB::transaction(function () use ($policy, $data, $updatedBy) {
            $maxVersion = LeavePolicyVersion::where('leave_policy_id', $policy->id)
                ->lockForUpdate()
                ->max('version');

            $nextVersion = $maxVersion ? ((int) $maxVersion) + 1 : 1;

            $data['updated_by'] = $updatedBy->id;
            $policy->update($data);
            $policy->refresh();

            $this->createVersionSnapshot($policy, $nextVersion, $updatedBy);

            return $policy->fresh(['versions', 'leaveTypes.organization', 'leaveTypes.policy']);
        });
    }

    /**
     * Get the active policy for an organization.
     *
     * @param Organization $organization
     * @return LeavePolicy
     */
    public function getPolicy(Organization $organization): LeavePolicy
    {
        $policy = LeavePolicy::where('organization_id', $organization->id)
            ->with(['versions', 'leaveTypes.organization', 'leaveTypes.policy'])
            ->first();

        if (!$policy) {
            throw new LeavePolicyNotFoundException();
        }

        return $policy;
    }

    /**
     * Get a policy by its UUID for a given organization.
     *
     * @param string $uuid
     * @param Organization $organization
     * @return LeavePolicy
     */
    public function getPolicyByUuid(string $uuid, Organization $organization): LeavePolicy
    {
        $policy = LeavePolicy::where('uuid', $uuid)
            ->where('organization_id', $organization->id)
            ->with(['versions', 'leaveTypes.organization', 'leaveTypes.policy'])
            ->first();

        if (!$policy) {
            throw new LeavePolicyNotFoundException();
        }

        return $policy;
    }

    /**
     * Get all versions of a policy, ordered by version descending.
     *
     * @param LeavePolicy $policy
     * @return Collection
     */
    public function getPolicyVersions(LeavePolicy $policy): Collection
    {
        return LeavePolicyVersion::where('leave_policy_id', $policy->id)
            ->orderBy('version', 'desc')
            ->get();
    }

    /**
     * Resolve the latest current version for a policy.
     *
     * @param LeavePolicy $policy
     * @return LeavePolicyVersion
     */
    public function resolveCurrentVersion(LeavePolicy $policy): LeavePolicyVersion
    {
        $version = LeavePolicyVersion::where('leave_policy_id', $policy->id)
            ->orderBy('version', 'desc')
            ->first();

        if (!$version) {
            throw new LeavePolicyNotFoundException('No version snapshot exists for this policy.');
        }

        return $version;
    }

    /**
     * Create an immutable snapshot version of the provided policy state.
     *
     * @param LeavePolicy $policy
     * @param int $version
     * @param User $createdBy
     * @return LeavePolicyVersion
     */
    private function createVersionSnapshot(LeavePolicy $policy, int $version, User $createdBy): LeavePolicyVersion
    {
        return LeavePolicyVersion::create([
            'leave_policy_id' => $policy->id,
            'version' => $version,
            'organization_id' => $policy->organization_id,
            'approval_flow' => $policy->approval_flow->value,
            'allow_half_day_leaves' => $policy->allow_half_day_leaves,
            'allow_leave_on_weekends' => $policy->allow_leave_on_weekends,
            'allow_leave_on_holidays' => $policy->allow_leave_on_holidays,
            'advance_notice_required_days' => $policy->advance_notice_required_days,
            'max_advance_application_days' => $policy->max_advance_application_days,
            'document_required_after_days' => $policy->document_required_after_days,
            'allow_leave_cancellation' => $policy->allow_leave_cancellation,
            'cancellation_before_hours' => $policy->cancellation_before_hours,
            'carry_forward_enabled' => $policy->carry_forward_enabled,
            'max_carry_forward_days' => $policy->max_carry_forward_days,
            'carry_forward_expiry_months' => $policy->carry_forward_expiry_months,
            'accrual_enabled' => $policy->accrual_enabled,
            'accrual_frequency' => $policy->accrual_frequency?->value,
            'negative_balance_allowed' => $policy->negative_balance_allowed,
            'auto_approve_after_hours' => $policy->auto_approve_after_hours,
            'created_by' => $createdBy->id,
            'created_at' => now(),
        ]);
    }
}
