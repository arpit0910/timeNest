<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\BaseApiException;

/**
 * Thrown when permission resolution fails due to data inconsistency.
 * HTTP 500 Internal Server Error.
 */
class PermissionResolutionException extends BaseApiException
{
    protected int $statusCode = 500;

    public function __construct(string $message = 'Permission resolution failed')
    {
        parent::__construct($message);
    }
}
