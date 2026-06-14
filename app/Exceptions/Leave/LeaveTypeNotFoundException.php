<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use Exception;
use Illuminate\Http\JsonResponse;

class LeaveTypeNotFoundException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Leave type not found.',
            'error_code' => 'LEAVE_TYPE_NOT_FOUND',
        ], 404);
    }
}
