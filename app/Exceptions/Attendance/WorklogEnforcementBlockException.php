<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class WorklogEnforcementBlockException extends RuntimeException
{
    public function __construct(string $message = 'You must submit your worklog for the previous working day before clocking in.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'WORKLOG_ENFORCEMENT_BLOCK',
        ], 422);
    }
}
