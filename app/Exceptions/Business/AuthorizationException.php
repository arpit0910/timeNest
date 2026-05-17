<?php

declare(strict_types=1);

namespace App\Exceptions\Business;

use App\Exceptions\BaseApiException;

/**
 * AuthorizationException — thrown when user lacks required permission/role.
 * HTTP 403 Forbidden.
 */
class AuthorizationException extends BaseApiException
{
    protected int $statusCode = 403;

    public function __construct(string $message = 'Access denied')
    {
        parent::__construct($message);
    }
}
