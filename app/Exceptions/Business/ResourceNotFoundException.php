<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * ResourceNotFoundException — thrown when a requested resource cannot be found.
 * HTTP 404 Not Found.
 */
class ResourceNotFoundException extends BaseApiException
{
    protected int $statusCode = 404;

    public function __construct(string $message = 'Resource not found', ?string $resourceType = null)
    {
        parent::__construct($message);
    }
}
