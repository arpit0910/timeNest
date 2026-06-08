<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

class UnauthorizedException extends BaseApiException
{
    protected int $statusCode = 401;
    protected bool $shouldLog = false;

    public function __construct(string $message = 'Unauthorized')
    {
        parent::__construct($message);
    }
}
