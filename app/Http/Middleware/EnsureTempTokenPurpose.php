<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Auth\JwtContext;
use App\Exceptions\Auth\InvalidTempTokenPurposeException;
use App\Exceptions\Business\JwtContextMissingException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the JWT is a temporary token with the specified purpose.
 *
 * THROWS exceptions for centralized handling:
 * - JwtContextMissingException (401)
 * - InvalidTempTokenPurposeException (403)
 *
 * Usage: ->middleware('jwt.temp:2fa')
 */
class EnsureTempTokenPurpose
{
    /**
     * Handle an incoming request.
     *
     * @throws JwtContextMissingException
     * @throws InvalidTempTokenPurposeException
     */
    public function handle(Request $request, Closure $next, string $purpose): Response
    {
        if (! app()->bound(JwtContext::class)) {
            throw new JwtContextMissingException('Unauthenticated. JWT context missing.');
        }

        $context = app(JwtContext::class);

        if (! $context->isTemp() || $context->purpose !== $purpose) {
            throw new InvalidTempTokenPurposeException();
        }

        return $next($request);
    }
}
