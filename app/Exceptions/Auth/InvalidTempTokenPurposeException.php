<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

/**
 * InvalidTempTokenPurposeException — thrown when a temporary token is used for wrong purpose.
 * Temp tokens are single-purpose (e.g., only for 2FA).
 * HTTP 403 Forbidden.
 */
class InvalidTempTokenPurposeException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Invalid token purpose')
    {
        parent::__construct($message);
    }
}
