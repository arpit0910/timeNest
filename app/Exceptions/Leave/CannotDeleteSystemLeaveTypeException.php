<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use Exception;
use Illuminate\Http\JsonResponse;

class CannotDeleteSystemLeaveTypeException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'System leave types cannot be deleted. Deactivate them instead.',
            'error_code' => 'CANNOT_DELETE_SYSTEM_LEAVE_TYPE',
        ], 422);
    }
}
