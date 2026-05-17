<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\Auth\User;
use App\Support\Security\Totp;
use Illuminate\Support\Facades\Hash;

class TwoFactorService
{
    public function verify(User $user, string $code): bool
    {
        $code = preg_replace('/\s+/', '', $code) ?? '';

        if ($code === '') {
            return false;
        }

        if (preg_match('/^\d{6}$/', $code) === 1 && $this->verifyTotp($user, $code)) {
            return true;
        }

        return $this->consumeRecoveryCode($user, $code);
    }

    private function verifyTotp(User $user, string $code): bool
    {
        if (! $user->two_factor_enabled || ! $user->two_factor_secret) {
            return false;
        }

        return Totp::verify($user->two_factor_secret, $code);
    }

    private function consumeRecoveryCode(User $user, string $code): bool
    {
        $recoveryCodes = $user->two_factor_recovery_codes ?? [];

        foreach ($recoveryCodes as $index => $hashedCode) {
            if (is_string($hashedCode) && Hash::check($code, $hashedCode)) {
                unset($recoveryCodes[$index]);
                $user->forceFill([
                    'two_factor_recovery_codes' => array_values($recoveryCodes),
                ])->save();

                return true;
            }
        }

        return false;
    }
}
