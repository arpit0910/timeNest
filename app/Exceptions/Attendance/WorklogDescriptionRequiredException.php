<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class WorklogDescriptionRequiredException extends RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'A description is required for worklog submissions.',
            'error_code' => 'WORKLOG_DESCRIPTION_REQUIRED',
        ], 422);
    }
}
