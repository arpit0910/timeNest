<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Attendance\AttendanceDay;
use App\Models\Attendance\AttendanceSession;
use App\Models\Attendance\AttendanceWorklog;
use App\Models\Attendance\WorklogPolicy;
use App\Models\Auth\User;
use App\Models\Project\Project;
use App\Models\Project\Milestone;
use App\Models\Project\Task;
use App\Models\Project\TaskTimeConsumption;
use Illuminate\Validation\ValidationException;

class AttendanceWorklogValidationService
{
    /**
     * Validate worklog details before creation or update.
     *
     * @throws BusinessRuleViolationException
     * @throws ValidationException
     */
    public function validate(
        User $user,
        AttendanceDay $day,
        WorklogPolicy $policy,
        array $data,
        ?AttendanceWorklog $existingWorklog = null
    ): void {
        // 1. Ownership checks
        if ($day->user_id !== $user->id) {
            throw new BusinessRuleViolationException('The attendance record does not belong to this user.', 'INVALID_ATTENDANCE_OWNER');
        }

        $sessionId = $data['attendance_session_id'] ?? null;
        if ($sessionId) {
            $session = AttendanceSession::find($sessionId);
            if (! $session || $session->attendance_day_id !== $day->id) {
                throw new BusinessRuleViolationException('The attendance session does not belong to the selected day.', 'INVALID_SESSION_DAY');
            }
        }

        // 1.5 Window locked check
        if ($policy->lock_after_days !== null && $policy->lock_after_days > 0) {
            $daysSince = \Carbon\Carbon::parse($day->attendance_date)->startOfDay()->diffInDays(now()->startOfDay());
            if ($daysSince >= $policy->lock_after_days) {
                throw new BusinessRuleViolationException('Submission window closed. This attendance day is locked.', 'WORKLOG_LOCKED');
            }
        }

        // 2. Policy-driven mapping checks
        if ($policy->require_project_mapping && empty($data['project_id'])) {
            throw ValidationException::withMessages([
                'project_id' => 'Project mapping is required by company policy.'
            ]);
        }

        if ($policy->require_task_mapping && empty($data['task_id'])) {
            throw ValidationException::withMessages([
                'task_id' => 'Task mapping is required by company policy.'
            ]);
        }

        // 3. Hierarchy Validation
        $projectId = $data['project_id'] ?? null;
        $milestoneId = $data['milestone_id'] ?? null;
        $taskId = $data['task_id'] ?? null;

        if ($taskId) {
            $task = Task::find($taskId);
            if (! $task) {
                throw ValidationException::withMessages(['task_id' => 'Invalid task.']);
            }

            // Milestone check
            $milestone = Milestone::find($milestoneId);
            if (! $milestone || $task->milestone_id !== $milestone->id) {
                throw ValidationException::withMessages([
                    'milestone_id' => 'The selected task does not belong to the selected milestone.'
                ]);
            }

            // Project check
            $project = Project::find($projectId);
            if (! $project || $milestone->project_id !== $project->id) {
                throw ValidationException::withMessages([
                    'project_id' => 'The selected milestone does not belong to the selected project.'
                ]);
            }

            // User project access check
            $userBelongsToProject = $project->users()->where('users.id', $user->id)->exists();
            if (! $userBelongsToProject) {
                throw new BusinessRuleViolationException('You are not assigned to this project.', 'PROJECT_ACCESS_DENIED');
            }

            // 4. Task Overflow check
            $loggedMinutes = (int) ($data['logged_minutes'] ?? 0);
            if ($loggedMinutes > 0 && $task->estimated_minutes > 0) {
                // Sum all other consumptions for this task, excluding this worklog if editing
                $query = TaskTimeConsumption::where('task_id', $task->id);
                if ($existingWorklog) {
                    $query->where('attendance_worklog_id', '!=', $existingWorklog->id);
                }
                $existingConsumption = (int) $query->sum('consumed_minutes');

                if ($existingConsumption + $loggedMinutes > $task->estimated_minutes) {
                    // Overflow occurred
                    if ($policy->require_justification_on_overflow && empty($data['justification'])) {
                        throw new \App\Exceptions\Attendance\WorklogOverflowJustificationRequiredException('Task estimated minutes exceeded. Justification is required.');
                    }
                }
            }
        }

        // 4.1 Description check
        if ($policy->require_description) {
            $desc = $data['description'] ?? '';
            if (empty($desc) || ($policy->min_description_length > 0 && strlen($desc) < $policy->min_description_length)) {
                throw new \App\Exceptions\Attendance\WorklogDescriptionRequiredException('Description is required and must meet minimum length by company policy.');
            }
        }

        // 4.2 Session Overflow check
        $loggedMinutes = (int) ($data['logged_minutes'] ?? 0);
        if ($sessionId && $loggedMinutes > 0) {
            $session = AttendanceSession::find($sessionId);
            $sessionMinutes = $session->clock_in_at->diffInMinutes($session->clock_out_at ?? now());
            
            // Allow a small grace period? Or just strict > ?
            if ($loggedMinutes > $sessionMinutes) {
                if ($policy->require_justification_on_overflow && empty($data['justification'])) {
                    throw new \App\Exceptions\Attendance\WorklogOverflowJustificationRequiredException('Logged minutes exceed session duration. Justification is required.');
                }
            }
        }

        // 5. Duplicate Submissions Policy
        if ($sessionId && ! $policy->allow_multiple_worklogs_per_session) {
            $query = AttendanceWorklog::where('attendance_session_id', $sessionId)
                ->where('id', '!=', $existingWorklog?->id);
            if ($query->exists()) {
                throw new \App\Exceptions\Attendance\WorklogAlreadyExistsForSessionException('Multiple worklogs are not allowed for this session.');
            }
        }

        // 6. Overlapping times if start_time & end_time are provided
        $startTime = $data['start_time'] ?? null;
        $endTime = $data['end_time'] ?? null;

        if ($startTime && $endTime) {
            $start = new \Carbon\Carbon($startTime);
            $end = new \Carbon\Carbon($endTime);

            if ($start->greaterThanOrEqualTo($end)) {
                throw ValidationException::withMessages([
                    'end_time' => 'End time must be after start time.'
                ]);
            }

            $query = AttendanceWorklog::where('user_id', $user->id)
                ->where('id', '!=', $existingWorklog?->id)
                ->where(function ($q) use ($start, $end) {
                    $q->where(function ($sub) use ($start, $end) {
                        $sub->where('start_time', '<', $end)
                            ->where('end_time', '>', $start);
                    });
                });

            if ($query->exists()) {
                throw new BusinessRuleViolationException('This worklog time range overlaps with another of your worklogs.', 'OVERLAPPING_WORKLOG_TIME');
            }
        }
    }
}
