<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * InvalidOperationException — thrown when an operation cannot be performed in current state.
 * HTTP 409 Conflict.
 *
 * Use this for: invalid state transitions, operations on inactive resources, etc.
 */
class InvalidOperationException extends BaseApiException
{
    protected int $statusCode = 409;

    public function __construct(string $message = 'Operation cannot be performed')
    {
        parent::__construct($message);
    }
}
