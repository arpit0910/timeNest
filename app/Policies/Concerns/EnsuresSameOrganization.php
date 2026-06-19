<?php

declare(strict_types=1);

namespace App\Policies\Concerns;

trait EnsuresSameOrganization
{
    protected function sameOrganization(int $modelOrganizationId): bool
    {
        $tenant = app('tenant.organization');

        return $tenant !== null && $modelOrganizationId === $tenant->id;
    }
}
