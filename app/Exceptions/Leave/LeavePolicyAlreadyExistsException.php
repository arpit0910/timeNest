<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use Exception;
use Illuminate\Http\JsonResponse;

class LeavePolicyAlreadyExistsException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'A leave policy already exists for this organization.',
            'error_code' => 'LEAVE_POLICY_ALREADY_EXISTS',
        ], 409);
    }
}
