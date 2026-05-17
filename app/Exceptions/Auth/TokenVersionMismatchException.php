<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

/**
 * TokenVersionMismatchException — thrown when JWT token_version claim doesn't match user's current version.
 * Indicates password change or forced logout since token issuance.
 * HTTP 401 Unauthorized.
 */
class TokenVersionMismatchException extends BaseApiException
{
    protected int $statusCode = 401;

    public function __construct(string $message = 'Token has been invalidated. Please log in again.')
    {
        parent::__construct($message);
    }
}
