<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use Exception;
use Illuminate\Http\JsonResponse;

class LeavePolicyNotFoundException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Leave policy not found.',
            'error_code' => 'LEAVE_POLICY_NOT_FOUND',
        ], 404);
    }
}
