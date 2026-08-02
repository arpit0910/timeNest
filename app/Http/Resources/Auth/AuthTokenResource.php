<?php

declare(strict_types=1);

namespace App\Http\Resources\Auth;

use App\Enums\SystemRole;
use App\Http\Resources\Organization\OrganizationSummaryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Auth Token Resource — wraps authentication response with tokens.
 *
 * Used for login, register, refresh, and organization selection responses.
 */
class AuthTokenResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'status' => $this->resource['status'] ?? 'authenticated',
        ];

        // Include tokens if authenticated
        if (isset($this->resource['access_token'])) {
            $data['access_token'] = $this->resource['access_token'];
            $data['refresh_token'] = $this->resource['refresh_token'];
            $data['token_type'] = $this->resource['token_type'] ?? 'bearer';
            $data['expires_in'] = $this->resource['expires_in'];
        }

        // Include temp token if intermediate state
        if (isset($this->resource['temp_token'])) {
            $data['temp_token'] = $this->resource['temp_token'];
        }

        // Guard and role info
        if (isset($this->resource['guard'])) {
            $data['guard'] = $this->resource['guard'];
        }
        if (isset($this->resource['role'])) {
            $data['role'] = $this->resource['role'];
            $data['role_label'] = SystemRole::tryFrom($this->resource['role'])?->label();
        }

        // Effective permissions for the active organization (or platform/none),
        // computed by AuthService::getEffectivePermissions() — never derived here.
        if (isset($this->resource['permissions'])) {
            $data['permissions'] = $this->resource['permissions'];
        }

        // User data
        if (isset($this->resource['user'])) {
            $data['user'] = new UserResource($this->resource['user']);
        }

        // Organization data
        if (isset($this->resource['organization'])) {
            $data['organization'] = new OrganizationSummaryResource($this->resource['organization']);
        }

        // Workspace list for selection
        if (isset($this->resource['workspaces'])) {
            $data['workspaces'] = $this->resource['workspaces'];
        }

        // Flags
        if (isset($this->resource['requires_2fa'])) {
            $data['requires_2fa'] = true;
        }
        if (isset($this->resource['requires_workspace_selection'])) {
            $data['requires_workspace_selection'] = true;
        }
        if (isset($this->resource['requires_verification'])) {
            $data['requires_verification'] = true;
        }

        // Message
        if (isset($this->resource['message'])) {
            $data['message'] = $this->resource['message'];
        }

        return $data;
    }
}
