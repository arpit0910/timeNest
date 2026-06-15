<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class WorklogAlreadyExistsForSessionException extends RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'A worklog already exists for this session. Multiple worklogs per session are not allowed by your organization policy.',
            'error_code' => 'WORKLOG_ALREADY_EXISTS_FOR_SESSION',
        ], 409);
    }
}
