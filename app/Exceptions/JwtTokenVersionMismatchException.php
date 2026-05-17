<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Auth\TokenVersionMismatchException;

/**
 * Legacy alias for backwards compatibility.
 * Use App\Exceptions\Auth\TokenVersionMismatchException instead.
 *
 * @deprecated Use App\Exceptions\Auth\TokenVersionMismatchException
 */
class JwtTokenVersionMismatchException extends TokenVersionMismatchException
{
    public function __construct(string $message = 'Token has been invalidated. Please log in again.')
    {
        parent::__construct($message);
    }
}
