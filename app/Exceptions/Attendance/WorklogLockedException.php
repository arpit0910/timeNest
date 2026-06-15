<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class WorklogLockedException extends RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'This worklog is locked and can no longer be modified.',
            'error_code' => 'WORKLOG_LOCKED',
        ], 422);
    }
}
