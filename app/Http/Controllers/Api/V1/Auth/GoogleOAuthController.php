<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Resources\Auth\AuthTokenResource;
use App\Services\Auth\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * GoogleOAuthController — handles Google Social Login flow.
 */
class GoogleOAuthController extends BaseApiController
{
    public function __construct(
        private readonly AuthService $authService,
    ) {}

    /**
     * GET /api/v1/auth/google/redirect
     *
     * Redirects the user to the Google OAuth consent screen.
     * Note: In a decoupled API/SPA architecture, the SPA often handles the redirect
     * and only sends the authorization code or access token to the backend.
     * However, this endpoint provides a pure backend-driven redirect option.
     *
     * @return RedirectResponse|JsonResponse
     */
    public function redirect()
    {
        try {
            return Socialite::driver('google')->stateless()->redirect();
        } catch (\Exception $e) {
            return $this->error('Could not initialize Google OAuth flow', status: 500);
        }
    }

    /**
     * GET /api/v1/auth/google/callback
     *
     * Handles the callback from Google, authenticates the user, and issues JWTs.
     */
    public function callback(Request $request): JsonResponse
    {
        try {
            $socialiteUser = Socialite::driver('google')->stateless()->user();

            $result = $this->authService->handleGoogleCallback(
                socialiteUser: $socialiteUser,
                ip: $request->ip(),
                userAgent: $request->userAgent(),
            );

            $status = match ($result['status']) {
                'authenticated' => 200,
                'requires_2fa' => 200,
                'requires_workspace_selection' => 200,
                'no_workspace' => 200,
                default => 200,
            };

            return $this->success(
                data: new AuthTokenResource($result),
                message: 'Google authentication successful',
                status: $status,
            );

        } catch (AuthenticationException $e) {
            return $this->unauthorized($e->getMessage());
        } catch (\Exception $e) {
            return $this->error('Authentication failed: '.$e->getMessage(), status: 400);
        }
    }
}
