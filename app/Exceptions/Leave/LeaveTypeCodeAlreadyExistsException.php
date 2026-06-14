<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use Exception;
use Illuminate\Http\JsonResponse;

class LeaveTypeCodeAlreadyExistsException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'A leave type with this code already exists for this organization.',
            'error_code' => 'LEAVE_TYPE_CODE_ALREADY_EXISTS',
        ], 409);
    }
}
