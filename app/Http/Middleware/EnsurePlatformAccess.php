<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\Business\InvalidOrganizationContextException;
use App\Exceptions\Business\JwtContextMissingException;
use App\Exceptions\Business\MembershipInactiveException;
use App\Models\Membership\PlatformMembership;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the current request carries a platform-level JWT guard.
 *
 * THROWS exceptions for centralized handling:
 * - JwtContextMissingException (401)
 * - InvalidOrganizationContextException (403)
 * - MembershipInactiveException (403)
 *
 * Must be placed AFTER jwt.auth in the middleware stack.
 */
class EnsurePlatformAccess
{
    /**
     * Handle an incoming request.
     *
     * @throws JwtContextMissingException
     * @throws InvalidOrganizationContextException
     * @throws MembershipInactiveException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! jwt_has_context()) {
            throw new JwtContextMissingException('Unauthenticated. JWT context missing.');
        }

        $context = jwt_context();

        if (! $context->isPlatform()) {
            throw new InvalidOrganizationContextException('Access denied. Platform-level authorization required.');
        }

        $membership = PlatformMembership::active()
            ->where('user_id', $request->user()->id)
            ->first();

        if (! $membership) {
            throw new MembershipInactiveException('Access denied');
        }

        // Set Spatie team to null for platform context (global permissions)
        setPermissionsTeamId(null);
        app()->instance('platform.membership', $membership);

        return $next($request);
    }
}
