<?php

declare(strict_types=1);

namespace App\Jobs\Auth;

use App\Mail\Auth\VerifyEmailMail;
use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * SendVerificationEmailJob — sends the verification email asynchronously.
 *
 * Queued to avoid blocking the registration HTTP response.
 * Retries up to 3 times with exponential backoff on transient SMTP failures.
 *
 * SECURITY: The raw token is never serialized in the job payload.
 * Only the pre-built verification URL (which contains the token) is stored.
 */
class SendVerificationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Backoff intervals (seconds) between retries — exponential.
     *
     * @var array<int, int>
     */
    public array $backoff = [10, 30, 60];

    /**
     * Maximum number of unhandled exceptions before the job is marked failed.
     */
    public int $maxExceptions = 2;

    /**
     * Create a new job instance.
     *
     * @param  User   $user             The recipient user (serialized via SerializesModels).
     * @param  string $verificationUrl  Pre-built frontend verification URL.
     */
    public function __construct(
        public readonly User $user,
        public readonly string $verificationUrl,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(
            new VerifyEmailMail($this->user, $this->verificationUrl)
        );
    }

    /**
     * Handle a job failure.
     *
     * Logs the failure for ops visibility without ever exposing the token.
     */
    public function failed(?\Throwable $exception): void
    {
        Log::error('Failed to send verification email', [
            'user_id' => $this->user->id,
            'email' => $this->user->email,
            'exception' => $exception?->getMessage(),
        ]);
    }
}
