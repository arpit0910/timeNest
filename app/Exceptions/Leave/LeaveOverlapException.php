<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use RuntimeException;
use Illuminate\Http\JsonResponse;

class LeaveOverlapException extends RuntimeException
{
    public function __construct(string $message = 'You already have a leave request for one or more of the selected dates.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'LEAVE_OVERLAP',
        ], 422);
    }
}