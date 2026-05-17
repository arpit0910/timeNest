<?php

declare(strict_types=1);

namespace App\Services\Corporation;

use App\Models\Auth\User;
use App\Models\Corporation\Branch;
use App\Models\Corporation\Corporation;
use App\Traits\HasAuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Handles core Corporation lifecycle (creation, updates, verification).
 */
class CorporationService
{
    use HasAuditLog;

    /**
     * Create a new corporation (e.g., during self-serve signup or platform admin creation).
     *
     * @param  User  $creator  The user who is creating the corporation (becomes owner)
     */
    public function createCorporation(array $data, User $creator): Corporation
    {
        return DB::transaction(function () use ($data) {
            $slug = Str::slug($data['trading_name'] ?? $data['legal_name']);

            // Ensure unique slug
            $originalSlug = $slug;
            $counter = 1;
            while (Corporation::where('slug', $slug)->exists()) {
                $slug = $originalSlug.'-'.$counter;
                $counter++;
            }

            $corp = Corporation::create([
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
                'country_id' => $data['country_id'] ?? null,
                'is_active' => true,
            ]);

            // Bind to container temporarily so audit log resolves corp ID
            app()->instance('current.corporation', $corp);

            // If HQ branch details provided, create it
            if (! empty($data['hq_name'])) {
                Branch::create([
                    'corporation_id' => $corp->id,
                    'name' => $data['hq_name'],
                    'code' => $data['hq_code'] ?? 'HQ',
                    'is_headquarters' => true,
                    'timezone' => $corp->timezone,
                    'country_id' => $corp->country_id,
                    'is_active' => true,
                ]);
            }

            $this->logAction('corporation.created', $corp, [], $corp->toArray());

            return $corp;
        });
    }

    /**
     * Update corporation profile details.
     */
    public function updateCorporation(Corporation $corp, array $data): Corporation
    {
        $old = $corp->toArray();
        $corp->update($data);

        // Temporarily bind for audit context
        app()->instance('current.corporation', $corp);
        $this->logAction('corporation.updated', $corp, $old, $corp->toArray());

        return $corp;
    }
}
