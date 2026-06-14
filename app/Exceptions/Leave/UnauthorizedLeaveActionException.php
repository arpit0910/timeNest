<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use RuntimeException;
use Illuminate\Http\JsonResponse;

class UnauthorizedLeaveActionException extends RuntimeException
{
    public function __construct(string $message = 'You are not authorized to perform this action on this leave request.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'UNAUTHORIZED_LEAVE_ACTION',
        ], 403);
    }
}