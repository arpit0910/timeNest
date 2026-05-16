<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Thrown when JWT token_version claim does not match the user's current token_version.
 * Indicates password change or forced logout since token issuance.
 * HTTP 401 Unauthorized.
 */
class JwtTokenVersionMismatchException extends HttpException
{
    public function __construct(string $message = 'Token has been invalidated. Please log in again.')
    {
        parent::__construct(401, $message);
    }
}
