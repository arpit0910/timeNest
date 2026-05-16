<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Auth\JwtContext;
use App\Exceptions\JwtTokenVersionMismatchException;
use App\Models\Auth\User;
use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
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
 * Binds authenticated user and JwtContext to the container.
 */
class JwtAuthenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $payload = JWTAuth::parseToken()->getPayload();
        } catch (TokenExpiredException) {
            return $this->errorResponse('Token has expired', 401);
        } catch (TokenInvalidException) {
            return $this->errorResponse('Token is invalid', 401);
        } catch (JWTException) {
            return $this->errorResponse('Token not provided', 401);
        }

        // Get user from token
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception) {
            return $this->errorResponse('User not found', 401);
        }

        if (!$user instanceof User) {
            return $this->errorResponse('User not found', 401);
        }

        // Build type-safe JWT context DTO
        $jwtContext = JwtContext::fromPayload($payload->toArray());

        // Verify token_version — mismatch means password changed or forced logout
        if ($jwtContext->tokenVersion !== $user->token_version) {
            throw new JwtTokenVersionMismatchException();
        }

        // Verify user is active
        if (!$user->is_active) {
            return $this->errorResponse('Account has been deactivated', 403);
        }

        // Bind JwtContext to the container as a singleton for the request lifecycle
        app()->instance(JwtContext::class, $jwtContext);

        // Set the authenticated user
        auth()->setUser($user);

        return $next($request);
    }

    /**
     * Return a standardized error response.
     */
    private function errorResponse(string $message, int $status): Response
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => null,
            'errors'  => null,
            'meta'    => null,
        ], $status);
    }
}
