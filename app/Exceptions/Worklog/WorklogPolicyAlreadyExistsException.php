<?php

declare(strict_types=1);

namespace App\Exceptions\Worklog;

use Exception;
use Illuminate\Http\JsonResponse;

class WorklogPolicyAlreadyExistsException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'A worklog policy already exists for this organization.',
            'error_code' => 'WORKLOG_POLICY_ALREADY_EXISTS',
        ], 409);
    }
}
