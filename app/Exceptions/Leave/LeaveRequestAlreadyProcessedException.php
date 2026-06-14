<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use RuntimeException;
use Illuminate\Http\JsonResponse;

class LeaveRequestAlreadyProcessedException extends RuntimeException
{
    public function __construct(string $message = 'This leave request has already been processed.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'LEAVE_REQUEST_ALREADY_PROCESSED',
        ], 422);
    }
}