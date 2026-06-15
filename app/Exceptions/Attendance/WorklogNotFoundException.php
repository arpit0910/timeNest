<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class WorklogNotFoundException extends RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'The requested worklog was not found.',
            'error_code' => 'WORKLOG_NOT_FOUND',
        ], 404);
    }
}
