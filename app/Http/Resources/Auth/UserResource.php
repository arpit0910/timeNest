<?php

declare(strict_types=1);

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * User API Resource — public representation of a User.
 *
 * NEVER exposes: id (integer), password, two_factor_secret, token_version.
 * Always uses uuid as the identifier.
 */
class UserResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'phone_verified' => $this->phone_verified,
            'avatar_url' => $this->avatar_url,
            'date_of_birth' => $this->date_of_birth?->toDateString(),
            'gender' => $this->gender,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'timezone' => $this->timezone,
            'locale' => $this->locale,
            'email_verified' => $this->email_verified_at !== null,
            'email_verified_at' => $this->email_verified_at?->toISOString(),
            'password_set' => $this->password_set,
            'two_factor_enabled' => $this->two_factor_enabled,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'is_active' => $this->is_active,
            'profile_completed_at' => $this->profile_completed_at?->toISOString(),
            'last_login_at' => $this->last_login_at?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
