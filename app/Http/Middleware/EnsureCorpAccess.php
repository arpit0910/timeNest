<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\Business\InvalidCorporationContextException;
use App\Exceptions\Business\JwtContextMissingException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the current request carries a corporation-level JWT guard
 * with a valid corporation_id claim.
 *
 * THROWS exceptions for centralized handling:
 * - JwtContextMissingException (401)
 * - InvalidCorporationContextException (403)
 *
 * Must be placed AFTER jwt.auth in the middleware stack.
 */
class EnsureCorpAccess
{
    /**
     * Handle an incoming request.
     *
     * @throws JwtContextMissingException
     * @throws InvalidCorporationContextException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! jwt_has_context()) {
            throw new JwtContextMissingException('Unauthenticated. JWT context missing.');
        }

        $context = jwt_context();

        $platformRole = resolve_platform_role($request->user());
        $isAppOwner = $platformRole && $platformRole->name === \App\Enums\SystemRole::AppOwner->value;

        if (! $isAppOwner) {
            if (! $context->isCorp() || ! $context->hasCorporationContext()) {
                throw new InvalidCorporationContextException('Access denied. Corporation-level authorization required.');
            }
        } else {
            // AppOwner must have some corporation context resolved (either in JWT or passed via header/request)
            $corpId = $context->corporationId 
                ?? $request->header('X-Corporation-Id') 
                ?? $request->input('corporation_id');
                
            $corpUuid = $context->corporationUuid 
                ?? $request->header('X-Corporation-Uuid') 
                ?? $request->input('corporation_uuid');

            if (! $corpId && ! $corpUuid) {
                throw new InvalidCorporationContextException('Access denied. Corporation context (ID or UUID) is required.');
            }
        }

        return $next($request);
    }
}
