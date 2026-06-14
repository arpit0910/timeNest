<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class MultipleSessionsNotAllowedException extends RuntimeException
{
    public function __construct(string $message = 'Your organization policy does not allow multiple clock-in sessions per day.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'MULTIPLE_SESSIONS_NOT_ALLOWED',
        ], 422);
    }
}
