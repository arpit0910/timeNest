<?php

declare(strict_types=1);

namespace App\Services\Corporation;

use App\Models\Corporation\Branch;
use App\Models\Corporation\Corporation;
use App\Traits\HasAuditLog;

/**
 * Handles Branch lifecycle within a Corporation.
 */
class BranchService
{
    use HasAuditLog;

    /**
     * Create a new branch.
     */
    public function createBranch(Corporation $corp, array $data): Branch
    {
        app()->instance('current.corporation', $corp);

        $branch = Branch::create([
            'corporation_id' => $corp->id,
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'is_headquarters' => $data['is_headquarters'] ?? false,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address_line_1' => $data['address_line_1'] ?? null,
            'address_line_2' => $data['address_line_2'] ?? null,
            'city' => $data['city'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'state_id' => $data['state_id'] ?? null,
            'country_id' => $data['country_id'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'geo_fence_radius' => $data['geo_fence_radius'] ?? null,
            'timezone' => $data['timezone'] ?? $corp->timezone,
            'is_active' => $data['is_active'] ?? true,
        ]);

        // If this is set as HQ, unset HQ flag on other branches
        if ($branch->is_headquarters) {
            Branch::where('corporation_id', $corp->id)
                ->where('id', '!=', $branch->id)
                ->update(['is_headquarters' => false]);
        }

        $this->logAction('branch.created', $branch, [], $branch->toArray());

        return $branch;
    }

    /**
     * Update an existing branch.
     */
    public function updateBranch(Branch $branch, array $data): Branch
    {
        app()->instance('current.corporation', $branch->corporation);

        $old = $branch->toArray();
        $branch->update($data);

        if ($branch->is_headquarters) {
            Branch::where('corporation_id', $branch->corporation_id)
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
        app()->instance('current.corporation', $branch->corporation);

        $branch->delete();
        $this->logAction('branch.deleted', $branch);
    }
}
