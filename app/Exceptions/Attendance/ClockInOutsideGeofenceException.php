<?php

declare(strict_types=1);

namespace App\Exceptions\Attendance;

use App\Exceptions\BaseApiException;
use Illuminate\Http\JsonResponse;

class ClockInOutsideGeofenceException extends BaseApiException
{
    /**
     * @var string
     */
    protected $message = 'Your clock-in location is outside the allowed radius for this organization.';

    /**
     * @var int
     */
    protected $code = 422;

    /**
     * Get the JSON response for the exception.
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->message,
            'data' => null,
            'errors' => null,
            'meta' => null,
            'error_code' => 'CLOCK_IN_OUTSIDE_GEOFENCE'
        ], $this->code);
    }
}
