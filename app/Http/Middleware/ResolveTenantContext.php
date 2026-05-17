<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\Business\CorporationInactiveException;
use App\Exceptions\Business\InvalidCorporationContextException;
use App\Exceptions\Business\JwtContextMissingException;
use App\Exceptions\Business\MembershipInactiveException;
use App\Models\Corporation\Corporation;
use App\Models\Membership\CorpMembership;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the tenant (Corporation) context from the JWT claims.
 *
 * Responsibilities:
 * 1. Loads the Corporation model from the JWT's corporation_id
 * 2. Validates the corporation is active
 * 3. Binds the Corporation to the container as 'tenant.corporation'
 * 4. Sets the Spatie team ID for permission resolution
 *
 * THROWS exceptions for centralized handling:
 * - JwtContextMissingException (401)
 * - InvalidCorporationContextException (403)
 * - CorporationInactiveException (403)
 * - MembershipInactiveException (403)
 *
 * Must be placed AFTER jwt.auth and corp.access in the middleware stack.
 * Replaces SetSpatieTeamId and all manual Corporation::findOrFail() calls in controllers.
 */
class ResolveTenantContext
{
    /**
     * Handle an incoming request.
     *
     * @throws JwtContextMissingException
     * @throws InvalidCorporationContextException
     * @throws CorporationInactiveException
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

        // Resolve corporation ID and UUID, allowing AppOwner header/request overrides
        $corpId = $context->corporationId;
        $corpUuid = $context->corporationUuid;

        if ($isAppOwner) {
            $corpId = $corpId 
                ?? $request->header('X-Corporation-Id') 
                ?? $request->input('corporation_id');
                
            $corpUuid = $corpUuid 
                ?? $request->header('X-Corporation-Uuid') 
                ?? $request->input('corporation_uuid');
        }

        if (! $corpId && ! $corpUuid) {
            throw new InvalidCorporationContextException('No corporation context available.');
        }

        // Find corporation
        $corporation = null;
        if ($corpId) {
            $corporation = Corporation::find($corpId);
        } elseif ($corpUuid) {
            $corporation = Corporation::where('uuid', $corpUuid)->first();
        }

        if (! $corporation) {
            // Don't leak that corporation exists
            throw new InvalidCorporationContextException('Invalid corporation context.');
        }

        if (! $corporation->is_active) {
            throw new CorporationInactiveException('Access denied');
        }

        if (! $isAppOwner) {
            if ($context->corporationUuid !== null && $context->corporationUuid !== $corporation->uuid) {
                throw new InvalidCorporationContextException('Invalid corporation context.');
            }

            $membership = CorpMembership::active()
                ->where('user_id', $request->user()->id)
                ->where('corporation_id', $corporation->id)
                ->first();

            if (! $membership) {
                throw new MembershipInactiveException('Access denied');
            }
        } else {
            $membership = null;
        }

        // Bind to container for downstream access
        app()->instance('tenant.corporation', $corporation);
        app()->instance('current.corporation', $corporation);
        if ($membership) {
            app()->instance('tenant.membership', $membership);
        }

        // Set Spatie team ID for permission resolution
        setPermissionsTeamId($corporation->id);

        return $next($request);
    }
}
