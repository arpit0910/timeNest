<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Resources\Auth\AuthTokenResource;
use App\Services\Auth\AuthService;
use App\Services\Auth\TwoFactorService;
use App\Exceptions\Auth\InvalidTempTokenPurposeException;
use App\Exceptions\Auth\InvalidTwoFactorCodeException;
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

        $context = jwt_context();

        // Ensure user is in 2FA temp state
        if (! $context || ! $context->isTemp() || $context->purpose !== '2fa') {
            throw new InvalidTempTokenPurposeException('Invalid token for 2FA verification');
        }

        if (! $this->twoFactorService->verify($user, (string) $request->input('code'))) {
            throw new InvalidTwoFactorCodeException();
        }

        // Issue real tokens now that 2FA is verified
        $result = $this->authService->issueTokensAfter2FA(
            user: $user,
            ip: $request->ip(),
            userAgent: $request->userAgent()
        );

        return $this->success(
            data: new AuthTokenResource($result),
            message: '2FA verified successfully',
            status: 200
        );
    }
}
