<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use RuntimeException;
use Illuminate\Http\JsonResponse;

class LeaveAdvanceNoticeException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'LEAVE_ADVANCE_NOTICE_REQUIRED',
        ], 422);
    }
}