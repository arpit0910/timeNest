<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use RuntimeException;
use Illuminate\Http\JsonResponse;

class LeaveAttendanceConflictException extends RuntimeException
{
    public function __construct(string $message = 'Leave request conflicts with existing approved attendance adjustment or attendance activity.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'LEAVE_ATTENDANCE_CONFLICT',
        ], 422);
    }
}
