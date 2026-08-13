<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use App\Services\Attendance\AttendancePolicyService;
use App\Services\Attendance\WorklogPolicyService;
use App\Services\Leave\LeavePolicyService;
use Illuminate\Console\Command;

/**
 * One-off/rerunnable backfill for organizations created before default
 * Attendance/Worklog/Leave policy provisioning was wired into
 * OrganizationService::createOrganization(). Safe to run repeatedly —
 * every underlying call is itself idempotent (firstOrCreate / exists-check).
 */
class BackfillDefaultPolicies extends Command
{
    protected $signature = 'policies:backfill-defaults {--org= : Only backfill a single organization UUID}';

    protected $description = 'Provision default attendance, worklog, and leave policies for organizations missing them';

    public function handle(
        AttendancePolicyService $attendancePolicyService,
        WorklogPolicyService $worklogPolicyService,
        LeavePolicyService $leavePolicyService,
    ): int {
        $query = Organization::query();

        if ($orgUuid = $this->option('org')) {
            $query->where('uuid', $orgUuid);
        }

        $organizations = $query->get();

        if ($organizations->isEmpty()) {
            $this->warn('No matching organizations found.');

            return self::SUCCESS;
        }

        $provisioned = 0;
        $skipped = 0;

        foreach ($organizations as $organization) {
            $creator = OrganizationMembership::where('organization_id', $organization->id)
                ->with('user')
                ->oldest()
                ->first()?->user;

            if (! $creator) {
                $this->warn("Skipping \"{$organization->legal_name}\" ({$organization->uuid}) — no membership found to attribute policies to.");
                $skipped++;

                continue;
            }

            $attendancePolicy = $attendancePolicyService->findPolicy($organization)
                ?? $attendancePolicyService->createDefaultPolicy($organization, $creator);

            $worklogPolicyService->getOrCreateWorklogPolicy($attendancePolicy, $creator);
            $leavePolicyService->getOrCreatePolicy($organization, $creator);

            $this->info("Provisioned defaults for \"{$organization->legal_name}\" ({$organization->uuid}).");
            $provisioned++;
        }

        $this->newLine();
        $this->info("Done. Provisioned: {$provisioned}, skipped: {$skipped}.");

        return self::SUCCESS;
    }
}
