<?php

declare(strict_types=1);

namespace App\Http\Resources\Organization;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'employee_code'   => $this->employee_code,
            'employment_type' => $this->employment_type?->value ?? clone $this->employment_type,
            'joining_date'    => $this->joining_date?->toDateString(),
            'confirmation_date' => $this->confirmation_date?->toDateString(),
            'exit_date'       => $this->exit_date?->toDateString(),
            'exit_reason'     => $this->exit_reason,
            'work_location'   => $this->work_location,
            'bio'             => $this->bio,
            'linkedin_url'    => $this->linkedin_url,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,
            'emergency_contact_relation' => $this->emergency_contact_relation,
            'is_active'       => $this->is_active,
            'documents'       => $this->documents,
            'user' => $this->whenLoaded('user', fn() => [
                'uuid'  => $this->user->uuid,
                'name'  => $this->user->name,
                'email' => $this->user->email,
            ]),
            'designation' => $this->whenLoaded('designation', fn() => [
                'uuid'  => $this->designation?->uuid,
                'name'  => $this->designation?->name,
                'level' => $this->designation?->level,
                'sub_department' => $this->designation?->relationLoaded('subDepartment') ? [
                    'uuid' => $this->designation->subDepartment?->uuid,
                    'name' => $this->designation->subDepartment?->name,
                    'department' => $this->designation->subDepartment?->relationLoaded('department') ? [
                        'uuid' => $this->designation->subDepartment->department?->uuid,
                        'name' => $this->designation->subDepartment->department?->name,
                    ] : null,
                ] : null,
            ]),
            'department' => $this->whenLoaded('department', fn() => [
                'uuid' => $this->department?->uuid,
                'name' => $this->department?->name,
            ]),
            'branch' => $this->whenLoaded('branch', fn() => [
                'uuid' => $this->branch?->uuid,
                'name' => $this->branch?->name,
            ]),
            'reports_to' => $this->whenLoaded('reportsTo', fn() => [
                'uuid' => $this->reportsTo?->uuid,
                'name' => $this->reportsTo?->name,
            ]),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
