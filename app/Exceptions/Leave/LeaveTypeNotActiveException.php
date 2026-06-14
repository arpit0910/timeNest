<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use RuntimeException;
use Illuminate\Http\JsonResponse;

class LeaveTypeNotActiveException extends RuntimeException
{
    public function __construct(string $message = 'This leave type is not currently available.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'LEAVE_TYPE_NOT_ACTIVE',
        ], 422);
    }
}