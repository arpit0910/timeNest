<?php

namespace App\Services\Auth;

use App\Models\Auth\TempToken;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class TempTokenService
{
    /**
     * Validate a temp token and consume it atomically.
     * Returns the TempToken model if valid.
     * Throws an exception if invalid, expired, or already used.
     */
    public function consume(string $rawToken, string $expectedPurpose): TempToken
    {
        // Decode the JWT to extract jti
        try {
            $payload = JWTAuth::setToken($rawToken)->getPayload();
        } catch (\Throwable $e) {
            throw new \App\Exceptions\Auth\InvalidTempTokenException(
                'Invalid temp token.'
            );
        }

        $jti = $payload->get('jti');
        $purpose = $payload->get('purpose');

        if ($purpose !== $expectedPurpose) {
            throw new \App\Exceptions\Auth\InvalidTempTokenException(
                'Temp token purpose mismatch.'
            );
        }

        // Atomic consume — find unused, unexpired token and mark used
        // in a single UPDATE to prevent race conditions
        $updated = DB::transaction(function () use ($jti) {
            $record = TempToken::where('jti', $jti)
                ->whereNull('used_at')
                ->where('expires_at', '>', now())
                ->lockForUpdate()
                ->first();

            if (!$record) {
                return null;
            }

            $record->update(['used_at' => now()]);
            return $record;
        });

        if (!$updated) {
            throw new \App\Exceptions\Auth\InvalidTempTokenException(
                'Temp token is invalid, expired, or already used.'
            );
        }

        return $updated;
    }
}
