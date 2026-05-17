<?php
declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

class InvalidTwoFactorCodeException extends BaseApiException
{
    public function __construct(string $message = "Invalid two-factor code", ?array $metadata = null)
    {
        parent::__construct($message, 400, "INVALID_2FA_CODE", $metadata);
        $this->setShouldLog(false);
    }
}
