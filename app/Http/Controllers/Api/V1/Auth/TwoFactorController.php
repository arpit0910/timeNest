<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Auth\TwoFactor\ConfirmSetupRequest;
use App\Http\Requests\Auth\TwoFactor\DisableRequest;
use App\Http\Requests\Auth\TwoFactor\InitiateSetupRequest;
use App\Http\Requests\Auth\TwoFactor\RegenerateRecoveryCodesRequest;
use App\Http\Requests\Auth\TwoFactor\VerifyRequest;
use App\Http\Resources\Auth\AuthTokenResource;
use App\Services\Auth\AuthService;
use App\Services\Auth\TwoFactorService;
use App\Exceptions\Auth\InvalidTempTokenPurposeException;
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
        private readonly \App\Services\Auth\TempTokenService $tempTokenService,
    ) {}

    public function status(Request $request): JsonResponse
    {
        $user = $request->user();
        
        return $this->success([
            'enabled'    => (bool) $user->two_factor_enabled_at,
            'enabled_at' => $user->two_factor_enabled_at,
        ]);
    }

    public function initiateSetup(InitiateSetupRequest $request): JsonResponse
    {
        $data = $this->twoFactorService->initiateSetup($request->user());
        return $this->success($data);
    }

    public function confirmSetup(ConfirmSetupRequest $request): JsonResponse
    {
        $data = $this->twoFactorService->confirmSetup($request->user(), $request->input('code'));
        
        return $this->success(
            $data,
            'Two-factor authentication has been enabled. Store your recovery codes in a safe place. They will not be shown again.'
        );
    }

    public function disable(DisableRequest $request): JsonResponse
    {
        $this->twoFactorService->disable($request->user(), $request->input('code'));
        
        return $this->success(null, 'Two-factor authentication has been disabled.');
    }

    public function regenerateRecoveryCodes(RegenerateRecoveryCodesRequest $request): JsonResponse
    {
        $data = $this->twoFactorService->regenerateRecoveryCodes($request->user(), $request->input('code'));
        
        return $this->success(
            $data,
            'Recovery codes regenerated. Your previous codes are now invalid.'
        );
    }

    /**
     * POST /api/v1/auth/2fa/verify
     *
     * Verify the 2FA code during the login flow using the temp token.
     */
    public function verify(VerifyRequest $request): JsonResponse
    {
        $user = $request->user();
        $context = jwt_context();

        // Ensure user is in 2FA temp state
        if (! $context || ! $context->isTemp() || $context->purpose !== '2fa') {
            throw new InvalidTempTokenPurposeException('Invalid token for 2FA verification');
        }

        $this->tempTokenService->consume(
            $request->bearerToken(),
            '2fa'
        );

        $code = (string) $request->input('code');
        $usedRecoveryCode = false;

        if (! $this->twoFactorService->verify($user, $code)) {
            if (! $this->twoFactorService->useRecoveryCode($user, $code)) {
                return $this->error('Invalid authentication code', [], 422);
            }
            $usedRecoveryCode = true;
        }

        // Issue real tokens now that 2FA is verified
        $result = $this->authService->issueTokensAfter2FA(
            user: $user,
            ip: $request->ip(),
            userAgent: $request->userAgent()
        );

        $message = '2FA verified successfully';
        if ($usedRecoveryCode) {
            $message = 'You used a recovery code. Please regenerate your codes or reconfigure 2FA.';
        }

        return $this->success(
            new AuthTokenResource($result),
            $message,
            200
        );
    }
}
