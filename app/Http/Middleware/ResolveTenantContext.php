<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\Business\OrganizationInactiveException;
use App\Exceptions\Business\InvalidOrganizationContextException;
use App\Exceptions\Business\JwtContextMissingException;
use App\Exceptions\Business\MembershipInactiveException;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationMembership;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the tenant (Organization) context from the JWT claims.
 *
 * Responsibilities:
 * 1. Loads the Organization model from the JWT's organization_id
 * 2. Validates the organization is active
 * 3. Binds the Organization to the container as 'tenant.organization'
 * 4. Sets the Spatie team ID for permission resolution
 *
 * THROWS exceptions for centralized handling:
 * - JwtContextMissingException (401)
 * - InvalidOrganizationContextException (403)
 * - OrganizationInactiveException (403)
 * - MembershipInactiveException (403)
 *
 * Must be placed AFTER jwt.auth and organization.access in the middleware stack.
 * Replaces SetSpatieTeamId and all manual Organization::findOrFail() calls in controllers.
 */
class ResolveTenantContext
{
    /**
     * Handle an incoming request.
     *
     * @throws JwtContextMissingException
     * @throws InvalidOrganizationContextException
     * @throws OrganizationInactiveException
     * @throws MembershipInactiveException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! jwt_has_context()) {
            throw new JwtContextMissingException('Unauthenticated. JWT context missing.');
        }

        $context = jwt_context();

        $platformRole = resolve_platform_role($request->user());
        $isAppOwner = $platformRole && $platformRole->name === \App\Enums\SystemRole::AppOwner->value;

        // Resolve organization UUID, allowing AppOwner header/request overrides
        $organizationUuid = $context->organizationUuid;

        if ($isAppOwner) {
            $organizationUuid = $organizationUuid 
                ?? $request->header('X-Organization-Uuid') 
                ?? $request->input('organization_uuid');
        }

        if (! $organizationUuid) {
            throw new InvalidOrganizationContextException('No organization context available.');
        }

        // Find organization
        $organization = Organization::where('uuid', $organizationUuid)->first();

        if (! $organization) {
            // Don't leak that organization exists
            throw new InvalidOrganizationContextException('Invalid organization context.');
        }

        if (! $organization->is_active) {
            throw new OrganizationInactiveException('Access denied');
        }

        if (! $isAppOwner) {
            if ($context->organizationUuid !== null && $context->organizationUuid !== $organization->uuid) {
                throw new InvalidOrganizationContextException('Invalid organization context.');
            }

            $membership = OrganizationMembership::active()
                ->where('user_id', $request->user()->id)
                ->where('organization_id', $organization->id)
                ->first();

            if (! $membership) {
                throw new MembershipInactiveException('Access denied');
            }
        } else {
            $membership = null;
        }

        // Bind to container for downstream access
        app()->instance('tenant.organization', $organization);
        app()->instance('current.organization', $organization);
        if ($membership) {
            app()->instance('tenant.membership', $membership);
        }

        // Set Spatie team ID for permission resolution
        setPermissionsTeamId($organization->id);

        return $next($request);
    }
}
