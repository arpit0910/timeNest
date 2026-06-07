<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Auth\Password\ForgotPasswordRequest;
use App\Http\Requests\Auth\Password\ResetPasswordRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Http\JsonResponse;

class PasswordResetController extends BaseApiController
{
    public function __construct(
        private readonly PasswordResetService $passwordResetService
    ) {}

    /**
     * POST /api/v1/auth/forgot-password
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->passwordResetService->requestReset($request->validated('email'));

        return $this->success(
            message: 'If an account with that email exists, a password reset token has been sent.'
        );
    }

    /**
     * POST /api/v1/auth/reset-password
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $success = $this->passwordResetService->resetPassword(
            $request->validated('email'),
            $request->validated('token'),
            $request->validated('password')
        );

        if (! $success) {
            return $this->error(
                message: 'Invalid or expired reset token.',
                status: 422
            );
        }

        return $this->success(
            message: 'Password has been reset successfully. Please log in.'
        );
    }
}
