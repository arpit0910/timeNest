<?php

declare(strict_types=1);

namespace App\Exceptions\Database;

use App\Exceptions\BaseApiException;

/**
 * IntegrityConstraintException — thrown when database integrity constraint fails.
 * HTTP 409 Conflict.
 *
 * Catches: duplicate entries, foreign key violations, unique constraint failures, etc.
 * Never exposes raw SQL or table names to the client.
 */
class IntegrityConstraintException extends BaseApiException
{
    protected int $statusCode = 409;

    public function __construct(string $message = 'Operation violates data constraints')
    {
        parent::__construct($message);
    }
}
