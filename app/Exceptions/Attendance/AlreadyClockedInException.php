<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class AlreadyClockedInException extends RuntimeException
{
    public function __construct(string $message = 'You already have an active clock-in session. Clock out first.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'ALREADY_CLOCKED_IN',
        ], 409);
    }
}
