<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Actions\IssueJwtAction;
use App\Models\Auth\PasswordResetToken;
use App\Models\Auth\User;
use App\Notifications\Auth\PasswordChangedNotification;
use App\Notifications\Auth\PasswordResetRequestedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordResetService
{
    public function __construct(
        private readonly IssueJwtAction $issueJwtAction
    ) {}

    /**
     * Handle a forgot password request.
     */
    public function requestReset(string $email): void
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            return;
        }

        $plainToken = bin2hex(random_bytes(32));
        $hashedToken = hash('sha256', $plainToken);

        PasswordResetToken::create([
            'user_id' => $user->id,
            'token' => $hashedToken,
            'expires_at' => now()->addMinutes((int) config('timenest.password_reset.expire', 60)),
            'used_at' => null,
            'created_at' => now(),
        ]);

        $user->notify(new PasswordResetRequestedNotification($plainToken, $user));
    }

    /**
     * Validate a submitted reset token.
     */
    public function validateResetToken(string $email, string $plainToken): ?PasswordResetToken
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            return null;
        }

        $hashedToken = hash('sha256', $plainToken);

        return PasswordResetToken::where('user_id', $user->id)
            ->where('token', $hashedToken)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Complete the password reset.
     */
    public function resetPassword(string $email, string $plainToken, string $newPassword): bool
    {
        $tokenRecord = $this->validateResetToken($email, $plainToken);

        if (! $tokenRecord) {
            return false;
        }

        $user = $tokenRecord->user;

        DB::transaction(function () use ($user, $tokenRecord, $newPassword) {
            $user->update([
                'password' => Hash::make($newPassword),
                'password_set' => true,
            ]);
            $user->incrementTokenVersion();

            $tokenRecord->update([
                'used_at' => now(),
            ]);

            $this->issueJwtAction->revokeAllRefreshTokens($user->id);
        });

        $user->notify(new PasswordChangedNotification($user));

        return true;
    }
}
