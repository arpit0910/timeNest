<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

/**
 * BaseApiException — base class for all API domain exceptions.
 *
 * Ensures all custom exceptions are properly renderable with:
 * - Human-readable messages
 * - Appropriate HTTP status codes
 * - Internal error codes for debugging
 * - Optional metadata
 *
 * All custom business exceptions should extend this class.
 */
abstract class BaseApiException extends Exception
{
    /**
     * HTTP status code for this exception.
     */
    protected int $statusCode = 500;

    /**
     * Internal error code for debugging (not exposed to client in production).
     */
    protected ?string $errorCode = null;

    /**
     * Optional metadata to include in the response.
     */
    protected ?array $metadata = null;

    /**
     * Whether to log this exception in production.
     */
    protected bool $shouldLog = true;

    public function __construct(string $message = '', int $statusCode = 0, ?string $errorCode = null, ?array $metadata = null)
    {
        parent::__construct($message);

        if ($statusCode > 0) {
            $this->statusCode = $statusCode;
        }

        $this->errorCode = $errorCode ?? $this->errorCode;
        $this->metadata = $metadata;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    public function shouldLog(): bool
    {
        return $this->shouldLog;
    }

    /**
     * Set whether this exception should be logged.
     */
    public function setShouldLog(bool $shouldLog): self
    {
        $this->shouldLog = $shouldLog;
        return $this;
    }

    /**
     * Render the exception as a JSON response.
     * Called by the centralized exception handler.
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error_code' => $this->errorCode,
            'message' => $this->getMessage(),
            'data' => null,
            'errors' => null,
            'meta' => $this->metadata,
        ], $this->statusCode);
    }
}
