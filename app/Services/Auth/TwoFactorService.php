<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\Auth\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FALaravel\Facade as Google2FA;

class TwoFactorService
{
    public function initiateSetup(User $user): array
    {
        $secret = Google2FA::generateSecretKey();
        
        $qrUrl = Google2FA::getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );
        
        Cache::put("2fa_setup_secret_{$user->id}", $secret, now()->addMinutes(10));
        
        return [
            'secret'           => $secret,
            'qr_code_url'      => $qrUrl,
            'manual_entry_key' => $secret,
        ];
    }

    public function confirmSetup(User $user, string $code): array
    {
        $secret = Cache::get("2fa_setup_secret_{$user->id}");
        
        if (! $secret) {
            throw ValidationException::withMessages([
                'code' => ['Setup session expired. Please reinitiate setup.'],
            ]);
        }

        $valid = Google2FA::verifyKey($secret, $code);
        
        if (! $valid) {
            throw ValidationException::withMessages([
                'code' => ['Invalid two-factor code.'],
            ]);
        }
        
        $recoveryCodes = $this->generateRecoveryCodes();
        
        $user->update([
            'two_factor_secret'         => $secret,
            'two_factor_recovery_codes' => $recoveryCodes['hashed'],
            'two_factor_enabled_at'     => now(),
        ]);
        
        $user->notify(new \App\Notifications\Auth\TwoFactorEnabledNotification($user));
        
        Cache::forget("2fa_setup_secret_{$user->id}");
        
        return ['recovery_codes' => $recoveryCodes['plain']];
    }

    public function verify(User $user, string $code): bool
    {
        if (! $user->two_factor_enabled_at || ! $user->two_factor_secret) {
            return false;
        }

        return Google2FA::verifyKey($user->two_factor_secret, $code);
    }

    public function disable(User $user, string $code): void
    {
        if (! $this->verify($user, $code)) {
            throw ValidationException::withMessages([
                'code' => ['Invalid two-factor code.'],
            ]);
        }
        
        $user->update([
            'two_factor_secret'         => null,
            'two_factor_recovery_codes' => null,
            'two_factor_enabled_at'     => null,
        ]);
        
        $user->notify(new \App\Notifications\Auth\TwoFactorDisabledNotification(
            $user,
            request()->ip() ?? '',
            request()->userAgent() ?? ''
        ));
    }

    public function generateRecoveryCodes(): array
    {
        $plain = [];
        $hashed = [];

        for ($i = 0; $i < 8; $i++) {
            $code = bin2hex(random_bytes(5)) . '-' . bin2hex(random_bytes(5));
            $plain[] = $code;
            $hashed[] = hash('sha256', $code);
        }

        return [
            'plain'  => $plain,
            'hashed' => $hashed,
        ];
    }

    public function regenerateRecoveryCodes(User $user, string $code): array
    {
        if (! $this->verify($user, $code)) {
            throw ValidationException::withMessages([
                'code' => ['Invalid two-factor code.'],
            ]);
        }
        
        $recoveryCodes = $this->generateRecoveryCodes();
        
        $user->update([
            'two_factor_recovery_codes' => $recoveryCodes['hashed'],
        ]);
        
        return ['recovery_codes' => $recoveryCodes['plain']];
    }

    public function useRecoveryCode(User $user, string $inputCode): bool
    {
        $recoveryCodes = $user->two_factor_recovery_codes ?? [];
        
        if (empty($recoveryCodes)) {
            return false;
        }
        
        $inputHash = hash('sha256', $inputCode);
        
        foreach ($recoveryCodes as $index => $storedHashedCode) {
            if (is_string($storedHashedCode) && hash_equals($inputHash, $storedHashedCode)) {
                unset($recoveryCodes[$index]);
                $remainingCodesArray = array_values($recoveryCodes);
                $user->forceFill([
                    'two_factor_recovery_codes' => $remainingCodesArray,
                ])->save();
                
                $remainingCount = count($remainingCodesArray);
                
                $user->notify(new \App\Notifications\Auth\RecoveryCodeUsedNotification(
                    $user,
                    request()->ip() ?? '',
                    request()->userAgent() ?? '',
                    $remainingCount
                ));
                
                if ($remainingCount === 0) {
                    $user->notify(new \App\Notifications\Auth\RecoveryCodesDepletedNotification($user));
                }
                
                return true;
            }
        }
        
        return false;
    }
}
