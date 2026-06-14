<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class AttendancePolicyNotFoundException extends RuntimeException
{
    public function __construct(string $message = 'Attendance policy not found.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'ATTENDANCE_POLICY_NOT_FOUND',
        ], 404);
    }
}
