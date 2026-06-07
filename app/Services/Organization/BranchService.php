<?php

declare(strict_types=1);

namespace App\Services\Organization;

use App\Models\Organization\Organization;
use App\Models\Organization\Branch;
use App\Traits\HasAuditLog;
use Illuminate\Support\Facades\DB;

/**
 * Handles Branch lifecycle within an Organization.
 */
class BranchService
{
    use HasAuditLog;

    /**
     * Create a new branch.
     */
    public function createBranch(Organization $organization, array $data): Branch
    {
        app()->instance('current.organization', $organization);

        return DB::transaction(function () use ($organization, $data) {
            $stateId = null;
            if (!empty($data['state_uuid'])) {
                $stateId = \App\Models\Location\State::where('uuid', $data['state_uuid'])->value('id');
            }

            $countryId = null;
            if (!empty($data['country_uuid'])) {
                $countryId = \App\Models\Location\Country::where('uuid', $data['country_uuid'])->value('id');
            }

            $branch = Branch::create([
                'organization_id' => $organization->id,
                'name' => $data['name'],
                'code' => $data['code'] ?? null,
                'is_headquarters' => $data['is_headquarters'] ?? false,
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
                'address_line_1' => $data['address_line_1'] ?? null,
                'address_line_2' => $data['address_line_2'] ?? null,
                'city' => $data['city'] ?? null,
                'postal_code' => $data['postal_code'] ?? null,
                'state_id' => $stateId ?? $data['state_id'] ?? null,
                'country_id' => $countryId ?? $data['country_id'] ?? null,
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'geo_fence_radius' => $data['geo_fence_radius'] ?? null,
                'timezone' => $data['timezone'] ?? $organization->timezone,
                'is_active' => $data['is_active'] ?? true,
            ]);

            // If this is set as HQ, unset HQ flag on other branches
            if ($branch->is_headquarters) {
                Branch::where('organization_id', $organization->id)
                    ->where('id', '!=', $branch->id)
                    ->update(['is_headquarters' => false]);
            }

            $this->logAction('branch.created', $branch, [], $branch->toArray());

            return $branch;
        });
    }

    /**
     * Update an existing branch.
     */
    public function updateBranch(Branch $branch, array $data): Branch
    {
        app()->instance('current.organization', $branch->organization);

        $old = $branch->toArray();
        $branch->update($data);

        if ($branch->is_headquarters) {
            Branch::where('organization_id', $branch->organization_id)
                ->where('id', '!=', $branch->id)
                ->update(['is_headquarters' => false]);
        }

        $this->logAction('branch.updated', $branch, $old, $branch->toArray());

        return $branch;
    }

    /**
     * Delete (soft) a branch.
     */
    public function deleteBranch(Branch $branch): void
    {
        app()->instance('current.organization', $branch->organization);

        $branch->delete();
        $this->logAction('branch.deleted', $branch);
    }
}
