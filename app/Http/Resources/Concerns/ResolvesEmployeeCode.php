<?php

declare(strict_types=1);

namespace App\Http\Resources\Concerns;

use App\Models\Auth\User;

trait ResolvesEmployeeCode
{
    /**
     * The user's employee code within one organization. Users can hold a profile
     * per organization, so the code is only meaningful alongside an org id.
     */
    protected function employeeCodeFor(?User $user, int|string|null $organizationId): ?string
    {
        if (! $user || ! $organizationId) {
            return null;
        }

        $profiles = $user->relationLoaded('employeeProfiles')
            ? $user->employeeProfiles
            : $user->employeeProfiles();

        return $profiles->where('organization_id', $organizationId)->first()?->employee_code;
    }
}
