<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Standardized API response envelope for all controllers.
 *
 * Provides consistent JSON structure across the entire API:
 * { success, message, data, errors, meta }
 */
trait ApiResponse
{
    /**
     * Return a success response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    protected function success(mixed $data = null, string $message = '', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'errors'  => null,
            'meta'    => null,
        ], $status);
    }

    /**
     * Return a created response (201).
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    protected function created(mixed $data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    /**
     * Return a no-content response (204).
     *
     * @return JsonResponse
     */
    protected function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @param array $errors
     * @param int $status
     * @return JsonResponse
     */
    protected function error(string $message, array $errors = [], int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => null,
            'errors'  => $errors ?: null,
            'meta'    => null,
        ], $status);
    }

    /**
     * Return a not-found response (404).
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return $this->error($message, status: 404);
    }

    /**
     * Return an unauthorized response (401).
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function unauthorized(string $message = 'Unauthenticated'): JsonResponse
    {
        return $this->error($message, status: 401);
    }

    /**
     * Return a forbidden response (403).
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function forbidden(string $message = 'Access denied'): JsonResponse
    {
        return $this->error($message, status: 403);
    }

    /**
     * Return a validation error response (422).
     *
     * @param array $errors
     * @param string $message
     * @return JsonResponse
     */
    protected function validationError(array $errors, string $message = 'Validation failed'): JsonResponse
    {
        return $this->error($message, $errors, 422);
    }

    /**
     * Return a paginated response with meta.
     *
     * @param JsonResource $resource
     * @param string $message
     * @return JsonResponse
     */
    protected function paginated(JsonResource $resource, string $message = ''): JsonResponse
    {
        $response = $resource->response()->getData(true);

        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $response['data'] ?? [],
            'errors'  => null,
            'meta'    => [
                'pagination' => $response['meta'] ?? null,
                'links'      => $response['links'] ?? null,
            ],
        ], 200);
    }
}
