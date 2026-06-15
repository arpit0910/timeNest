<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class WorklogOverflowJustificationRequiredException extends RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Your logged time exceeds the session duration. A justification is required.',
            'error_code' => 'WORKLOG_OVERFLOW_JUSTIFICATION_REQUIRED',
        ], 422);
    }
}
