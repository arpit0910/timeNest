<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

/**
 * Thrown when permission resolution fails due to data inconsistency.
 * HTTP 500 Internal Server Error.
 */
class PermissionResolutionException extends RuntimeException
{
    public function __construct(string $message = 'Permission resolution failed')
    {
        parent::__construct($message);
    }
}
