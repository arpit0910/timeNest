<?php

declare(strict_types=1);

namespace App\Services\Organization;

use App\Models\Auth\User;
use App\Models\Organization\Branch;
use App\Models\Organization\Organization;
use App\Traits\HasAuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Handles core Organization lifecycle (creation, updates, verification).
 */
class OrganizationService
{
    use HasAuditLog;

    /**
     * Create a new organization (e.g., during self-serve signup or platform admin creation).
     *
     * @param  User  $creator  The user who is creating the organization (becomes owner)
     */
    public function createOrganization(array $data, User $creator): Organization
    {
        return DB::transaction(function () use ($data) {
            $slug = generate_unique_slug($data['trading_name'] ?? $data['legal_name'], Organization::class);

            $organization = Organization::create([
                'legal_name' => $data['legal_name'],
                'trading_name' => $data['trading_name'] ?? null,
                'slug' => $slug,
                'legal_entity_type' => $data['legal_entity_type'] ?? null,
                'industry' => $data['industry'] ?? null,
                'company_size' => $data['company_size'] ?? null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'timezone' => $data['timezone'] ?? 'UTC',
                'locale' => $data['locale'] ?? 'en',
                'currency_code' => $data['currency_code'] ?? 'USD',
                'plan' => $data['plan'] ?? 'free',
                'max_users' => $data['max_users'] ?? 5,
                'country_id' => isset($data['country_uuid']) 
                    ? \App\Models\System\Country::where('uuid', $data['country_uuid'])->value('id') 
                    : null,
                'is_active' => true,
            ]);

            // Bind to container temporarily so audit log resolves org ID
            app()->instance('current.organization', $organization);

            // If HQ branch details provided, create it
            if (! empty($data['hq_name'])) {
                Branch::create([
                    'organization_id' => $organization->id,
                    'name' => $data['hq_name'],
                    'code' => $data['hq_code'] ?? 'HQ',
                    'is_headquarters' => true,
                    'timezone' => $organization->timezone,
                    'country_id' => $organization->country_id,
                    'is_active' => true,
                ]);
            }

            $this->logAction('organization.created', $organization, [], $organization->toArray());

            return $organization;
        });
    }

    /**
     * Update organization profile details.
     */
    public function updateOrganization(Organization $organization, array $data): Organization
    {
        if (isset($data['country_uuid'])) {
            $data['country_id'] = \App\Models\System\Country::where('uuid', $data['country_uuid'])->value('id');
            unset($data['country_uuid']);
        }

        $old = $organization->toArray();
        $organization->update($data);

        // Bind to container temporarily so audit log resolves org ID
        app()->instance('current.organization', $organization);
        $this->logAction('organization.updated', $organization, $old, $organization->toArray());

        return $organization;
    }
}
