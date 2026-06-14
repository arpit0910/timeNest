<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class NoActiveSessionException extends RuntimeException
{
    public function __construct(string $message = 'No active clock-in session found.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'NO_ACTIVE_SESSION',
        ], 422);
    }
}
