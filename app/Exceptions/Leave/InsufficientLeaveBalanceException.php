<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use RuntimeException;
use Illuminate\Http\JsonResponse;

class InsufficientLeaveBalanceException extends RuntimeException
{
    public function __construct(string $message = 'Insufficient leave balance for this request.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'INSUFFICIENT_LEAVE_BALANCE',
        ], 422);
    }
}