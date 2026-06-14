<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class AttendancePolicyAlreadyExistsException extends RuntimeException
{
    public function __construct(string $message = 'An attendance policy already exists for this organization.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'ATTENDANCE_POLICY_ALREADY_EXISTS',
        ], 409);
    }
}
