<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use RuntimeException;
use Illuminate\Http\JsonResponse;

class LeaveDocumentRequiredException extends RuntimeException
{
    public function __construct(string $message = 'A supporting document is required for this leave request.')
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => 'LEAVE_DOCUMENT_REQUIRED',
        ], 422);
    }
}