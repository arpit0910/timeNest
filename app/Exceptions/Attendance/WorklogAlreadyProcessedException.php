<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class WorklogAlreadyProcessedException extends RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'This worklog has already been processed.',
            'error_code' => 'WORKLOG_ALREADY_PROCESSED',
        ], 422);
    }
}
