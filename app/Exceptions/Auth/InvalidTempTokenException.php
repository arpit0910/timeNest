<?php

namespace App\Exceptions\Auth;

use Exception;

class InvalidTempTokenException extends Exception
{
    public function __construct(string $message = 'Invalid temp token.')
    {
        parent::__construct($message);
    }
}
