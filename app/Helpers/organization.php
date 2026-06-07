<?php

declare(strict_types=1);

use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use Illuminate\Support\Str;

if (! function_exists('tenant_organization')) {
    /**
     * Get the active tenant Organization instance from the container.
     */
    function tenant_organization(): ?Organization
    {
        return app()->bound('tenant.organization') ? app('tenant.organization') : null;
    }
}

if (! function_exists('tenant_membership')) {
    /**
     * Get the active tenant membership instance from the container.
     */
    function tenant_membership(): ?OrganizationMembership
    {
        return app()->bound('tenant.membership') ? app('tenant.membership') : null;
    }
}

if (! function_exists('generate_unique_slug')) {
    /**
     * Generate a unique slug for a given model.
     */
    function generate_unique_slug(string $value, string $modelClass, string $field = 'slug'): string
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $counter = 1;

        while ($modelClass::where($field, $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
