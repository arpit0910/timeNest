<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Auth\JwtContext;
use App\Http\Controllers\BaseApiController;
use App\Http\Resources\Auth\AuthTokenResource;
use App\Services\Auth\AuthService;
use App\Services\Auth\TwoFactorService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * TwoFactorController — handles 2FA verification during login and setup.
 */
class TwoFactorController extends BaseApiController
{
    public function __construct(
        private readonly AuthService $authService,
        private readonly TwoFactorService $twoFactorService,
    ) {}

    /**
     * POST /api/v1/auth/2fa/verify
     *
     * Verify the 2FA code during the login flow using the temp token.
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'min:6', 'max:32'],
        ]);

        $user = $request->user();

        $context = app(JwtContext::class);

        // Ensure user is in 2FA temp state
        if (! $context->isTemp() || $context->purpose !== '2fa') {
            return $this->forbidden('Invalid token for 2FA verification');
        }

        if (! $this->twoFactorService->verify($user, (string) $request->input('code'))) {
            return $this->error('Invalid two-factor code', status: 400);
        }

        // Issue real tokens now that 2FA is verified
        try {
            $result = $this->authService->issueTokensAfter2FA(
                user: $user,
                ip: $request->ip(),
                userAgent: $request->userAgent()
            );

            $status = match ($result['status']) {
                'authenticated' => 200,
                'requires_workspace_selection' => 200,
                'no_workspace' => 200,
                default => 200,
            };

            return $this->success(
                data: new AuthTokenResource($result),
                message: '2FA verified successfully',
                status: $status
            );
        } catch (AuthenticationException $e) {
            return $this->forbidden($e->getMessage());
        } catch (\Exception) {
            return $this->error('Failed to issue tokens after 2FA', status: 500);
        }
    }
}
