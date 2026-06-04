<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Jobs\Auth\SendVerificationEmailJob;
use App\Models\Auth\User;

/**
 * SendEmailVerificationAction — builds the verification URL and dispatches
 * the queued email job.
 *
 * Reusable across registration, resend, and any future flow that needs
 * to trigger a verification email. Keeps URL-building logic centralized
 * so it is never duplicated in services or controllers.
 */
class SendEmailVerificationAction
{
    /**
     * Build the verification URL and dispatch the email job.
     *
     * @param  User   $user      The user to send the verification email to.
     * @param  string $rawToken  The unhashed verification token (exists only in memory).
     */
    public function execute(User $user, string $rawToken): void
    {
        $verificationUrl = $this->buildVerificationUrl($rawToken);

        SendVerificationEmailJob::dispatch($user, $verificationUrl);
    }

    /**
     * Build the frontend verification URL.
     *
     * The raw token is embedded as a query parameter — the frontend will
     * extract it and POST to the backend verify-email endpoint.
     */
    private function buildVerificationUrl(string $rawToken): string
    {
        $frontendUrl = rtrim((string) config('timenest.frontend_url'), '/');

        return $frontendUrl . '/verify-email?token=' . $rawToken;
    }
}
