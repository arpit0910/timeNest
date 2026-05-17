<?php
declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

class TwoFactorRequiredException extends BaseApiException
{
    public function __construct(string $message = "Two-factor authentication required", ?array $metadata = null)
    {
        parent::__construct($message, 403, "TWO_FACTOR_REQUIRED", $metadata);
        $this->setShouldLog(false);
    }
}
