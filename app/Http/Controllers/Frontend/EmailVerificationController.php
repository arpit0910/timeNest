<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {}

    /**
     * GET /verify-email?token=...
     *
     * Handles the browser click from the verification email.
     * Verifies the token and shows a success or error page.
     */
    public function verify(Request $request): View
    {
        $token = $request->query('token');

        if (! $token || ! is_string($token) || strlen($token) !== 64) {
            return view('frontend.pages.verify-email', [
                'success' => false,
                'heading' => 'Invalid Verification Link',
                'message' => 'The verification link is malformed or incomplete. Please request a new verification email.',
            ]);
        }

        try {
            $this->authService->verifyEmail($token);

            return view('frontend.pages.verify-email', [
                'success' => true,
                'heading' => 'Email Verified Successfully',
                'message' => 'Your email address has been verified. You can now log in to your timeNest account.',
            ]);
        } catch (\Exception) {
            return view('frontend.pages.verify-email', [
                'success' => false,
                'heading' => 'Verification Failed',
                'message' => 'This verification link is invalid or has expired. Please request a new verification email.',
            ]);
        }
    }
}
