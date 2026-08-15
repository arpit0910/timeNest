<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\NotificationTypeEnum;
use App\Models\Membership\EmployeeProfile;

/**
 * Employee profiles are usually edited by an admin on someone else's behalf,
 * so the person concerned is told what changed. Self-edits are skipped by the
 * notification service's actor check.
 */
class EmployeeProfileObserver
{
    /**
     * Fields worth a notification. Anything else (timestamps, bookkeeping)
     * changes too often to be interesting.
     *
     * @var array<string, string>
     */
    private const WATCHED = [
        'employee_code' => 'employee code',
        'employment_type' => 'employment type',
        'joining_date' => 'joining date',
        'confirmation_date' => 'confirmation date',
        'exit_date' => 'exit date',
        'work_location' => 'work location',
        'department_id' => 'department',
        'designation_id' => 'designation',
        'branch_id' => 'branch',
        'reports_to' => 'reporting manager',
        'is_active' => 'status',
    ];

    public function updated(EmployeeProfile $profile): void
    {
        $changed = array_keys(array_intersect_key($profile->getDirty(), self::WATCHED));

        if ($changed === []) {
            return;
        }

        // A new manager is a bigger deal than a field edit, so it gets its own
        // notification rather than being folded into the summary.
        if (in_array('reports_to', $changed, true) && $profile->reports_to !== null) {
            $manager = $profile->reportsTo?->name;

            notify_user($profile->user_id, NotificationTypeEnum::EMPLOYEE_PROFILE_UPDATED, [
                'title' => 'Reporting manager changed',
                'body' => $manager ? "You now report to {$manager}." : 'Your reporting manager was updated.',
                'organization_id' => $profile->organization_id,
                'subject' => $profile,
                'actor' => auth()->id(),
            ]);
        }

        if (in_array('designation_id', $changed, true) && $profile->designation_id !== null) {
            $designation = $profile->designation?->name;

            notify_user($profile->user_id, NotificationTypeEnum::DESIGNATION_ASSIGNED, [
                'body' => $designation ? "Your designation is now {$designation}." : 'Your designation was updated.',
                'organization_id' => $profile->organization_id,
                'subject' => $profile,
                'actor' => auth()->id(),
            ]);
        }

        $others = array_values(array_diff($changed, ['reports_to', 'designation_id']));

        if ($others === []) {
            return;
        }

        $labels = array_map(fn (string $field) => self::WATCHED[$field], $others);

        notify_user($profile->user_id, NotificationTypeEnum::EMPLOYEE_PROFILE_UPDATED, [
            'body' => 'Your '.$this->humanList($labels).' was updated.',
            'organization_id' => $profile->organization_id,
            'subject' => $profile,
            'actor' => auth()->id(),
            'data' => ['changed' => $others],
        ]);
    }

    /** "a, b and c" — readable in a notification body. */
    private function humanList(array $items): string
    {
        if (count($items) === 1) {
            return $items[0];
        }

        $last = array_pop($items);

        return implode(', ', $items).' and '.$last;
    }
}
