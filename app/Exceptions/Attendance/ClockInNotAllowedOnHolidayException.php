<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class ClockInNotAllowedOnHolidayException extends RuntimeException
{
    public function __construct(string $message = 'Clock-in is not permitted on holidays as per your organization policy.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'CLOCK_IN_NOT_ALLOWED_ON_HOLIDAY',
        ], 422);
    }
}
