<?php

declare(strict_types=1);

namespace App\Http\Middleware;

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
 * Binds authenticated user to the request.
 */
class JwtAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
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

        // Verify token_version — mismatch means password changed or forced logout
        $claimedVersion = (int) $payload->get('token_version', 0);
        if ($claimedVersion !== $user->token_version) {
            throw new JwtTokenVersionMismatchException();
        }

        // Verify user is active
        if (!$user->is_active) {
            return $this->errorResponse('Account has been deactivated', 403);
        }

        // Bind user and payload to request for downstream use
        $request->merge([
            'jwt_guard'         => $payload->get('guard'),
            'jwt_corporation_id' => $payload->get('corporation_id'),
            'jwt_role'          => $payload->get('role'),
        ]);

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
