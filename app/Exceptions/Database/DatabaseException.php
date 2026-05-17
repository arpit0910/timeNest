<?php

declare(strict_types=1);

namespace App\Exceptions\Database;

use App\Exceptions\BaseApiException;

/**
 * DatabaseException — generic database operation failure.
 * HTTP 500 Internal Server Error.
 *
 * Used for: connection failures, transaction failures, SQL syntax errors, deadlocks, etc.
 * Always logs the full exception. Never exposes internals to client.
 */
class DatabaseException extends BaseApiException
{
    protected int $statusCode = 500;

    public function __construct(string $message = 'Database operation failed')
    {
        parent::__construct($message);
    }
}
