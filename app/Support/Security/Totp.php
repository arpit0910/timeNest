<?php

declare(strict_types=1);

namespace App\Support\Security;

class Totp
{
    private const TIME_STEP_SECONDS = 30;

    private const WINDOW = 1;

    private const DIGITS = 6;

    /**
     * Verify a TOTP code against a secret.
     */
    public static function verify(string $secret, string $code): bool
    {
        $decodedSecret = self::base32Decode($secret);

        if ($decodedSecret === null) {
            return false;
        }

        $counter = intdiv(time(), self::TIME_STEP_SECONDS);

        for ($offset = -self::WINDOW; $offset <= self::WINDOW; $offset++) {
            if (hash_equals(self::totp($decodedSecret, $counter + $offset), $code)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate TOTP hash value for a given counter.
     */
    public static function totp(string $secret, int $counter): string
    {
        $binaryCounter = pack('N2', intdiv($counter, 0x100000000), $counter % 0x100000000);
        $hash = hash_hmac('sha1', $binaryCounter, $secret, true);
        $offset = ord($hash[strlen($hash) - 1]) & 0x0F;

        $value = (
            ((ord($hash[$offset]) & 0x7F) << 24) |
            ((ord($hash[$offset + 1]) & 0xFF) << 16) |
            ((ord($hash[$offset + 2]) & 0xFF) << 8) |
            (ord($hash[$offset + 3]) & 0xFF)
        ) % (10 ** self::DIGITS);

        return str_pad((string) $value, self::DIGITS, '0', STR_PAD_LEFT);
    }

    /**
     * Decode a base32 encoded string.
     */
    public static function base32Decode(string $secret): ?string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = strtoupper(rtrim(str_replace(' ', '', $secret), '='));
        $bits = '';

        foreach (str_split($secret) as $character) {
            $value = strpos($alphabet, $character);

            if ($value === false) {
                return null;
            }

            $bits .= str_pad(decbin($value), 5, '0', STR_PAD_LEFT);
        }

        $decoded = '';

        foreach (str_split($bits, 8) as $chunk) {
            if (strlen($chunk) === 8) {
                $decoded .= chr(bindec($chunk));
            }
        }

        return $decoded !== '' ? $decoded : null;
    }
}
