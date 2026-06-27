<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\Business\InvalidOrganizationContextException;
use App\Exceptions\Business\JwtContextMissingException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the current request carries a organization-level JWT guard
 * with a valid organization_id claim.
 *
 * THROWS exceptions for centralized handling:
 * - JwtContextMissingException (401)
 * - InvalidOrganizationContextException (403)
 *
 * Must be placed AFTER jwt.auth in the middleware stack.
 */
class EnsureOrganizationAccess
{
    /**
     * Handle an incoming request.
     *
     * @throws JwtContextMissingException
     * @throws InvalidOrganizationContextException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! jwt_has_context()) {
            throw new JwtContextMissingException('Unauthenticated. JWT context missing.');
        }

        $context = jwt_context();

        $platformRole = resolve_platform_role($request->user());
        $isAppOwner = $platformRole && $platformRole->name === \App\Enums\SystemRole::APP_DIRECTOR->value;

        if (! $isAppOwner) {
            if (! $context->isOrganization() || ! $context->hasOrganizationContext()) {
                throw new InvalidOrganizationContextException('Access denied. Organization-level authorization required.');
            }
        } else {
            // AppOwner must have some organization context resolved (either in JWT or passed via header/request)
            $organizationUuid = $context->organizationUuid 
                ?? $request->header('X-Organization-Uuid') 
                ?? $request->input('organization_uuid');
                
            if (! $organizationUuid) {
                throw new InvalidOrganizationContextException('Access denied. Organization context (UUID) is required.');
            }
        }

        return $next($request);
    }
}
