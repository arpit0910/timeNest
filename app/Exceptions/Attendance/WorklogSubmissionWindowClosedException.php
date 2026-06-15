<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class WorklogSubmissionWindowClosedException extends RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'The submission window for this worklog has closed.',
            'error_code' => 'WORKLOG_SUBMISSION_WINDOW_CLOSED',
        ], 422);
    }
}
