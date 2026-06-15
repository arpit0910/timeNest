<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class UnauthorizedWorklogActionException extends RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to perform this action on this worklog.',
            'error_code' => 'UNAUTHORIZED_WORKLOG_ACTION',
        ], 403);
    }
}
