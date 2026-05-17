<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Auth\JwtContext;
use App\Exceptions\Auth\AccountInactiveException;
use App\Exceptions\Auth\TokenVersionMismatchException;
use App\Exceptions\Auth\UserNotFoundException;
use App\Exceptions\Business\JwtContextMissingException;
use App\Models\Auth\User;
use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

/**
 * JWT authentication middleware.
 *
 * Validates:
 * 1. JWT signature and structure
 * 2. Token expiry
 * 3. Blacklist check (jti not revoked)
 * 4. token_version matches user's current version
 * 5. User is active
 *
 * THROWS exceptions for centralized handling:
 * - TokenExpiredException (mapped from JWT library)
 * - TokenInvalidException (mapped from JWT library)
 * - TokenNotProvidedException (mapped from JWT library)
 * - UserNotFoundException
 * - TokenVersionMismatchException
 * - AccountInactiveException
 *
 * Binds authenticated user and JwtContext to the container on success.
 */
class JwtAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @throws JWTException
     * @throws UserNotFoundException
     * @throws TokenVersionMismatchException
     * @throws AccountInactiveException
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Parse and validate JWT signature
        // Exceptions thrown here are caught by centralized handler
        $payload = JWTAuth::parseToken()->getPayload();

        // Get user from token
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception) {
            throw new UserNotFoundException();
        }

        if (! $user instanceof User) {
            throw new UserNotFoundException();
        }

        // Build type-safe JWT context DTO
        $jwtContext = JwtContext::fromPayload($payload->toArray());

        // Verify token_version — mismatch means password changed or forced logout
        if ($jwtContext->tokenVersion !== $user->token_version) {
            throw new TokenVersionMismatchException();
        }

        // Verify user is active
        if (! $user->is_active) {
            throw new AccountInactiveException();
        }

        // Bind JwtContext to the container as a singleton for the request lifecycle
        app()->instance(JwtContext::class, $jwtContext);

        // Set the authenticated user
        auth()->setUser($user);

        return $next($request);
    }
}
