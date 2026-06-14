<?php

declare(strict_types=1);

namespace App\Exceptions\Worklog;

use Exception;
use Illuminate\Http\JsonResponse;

class WorklogPolicyNotFoundException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Worklog policy not found.',
            'error_code' => 'WORKLOG_POLICY_NOT_FOUND',
        ], 404);
    }
}
