<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use Illuminate\Http\JsonResponse;
use RuntimeException;

class InvalidPenaltySlabException extends RuntimeException
{
    public function __construct(string $message = 'Invalid penalty slab configuration.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'INVALID_PENALTY_SLAB',
        ], 422);
    }
}
