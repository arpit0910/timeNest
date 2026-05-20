<?php

declare(strict_types=1);

namespace App\Services\Attendance;

use App\Exceptions\Business\BusinessRuleViolationException;
use App\Models\Corporation\Branch;
use App\Models\Corporation\Corporation;

class GeofenceService
{
    /**
     * Calculate the distance between two GPS coordinates using the Haversine formula.
     * Returns distance in meters.
     */
    public function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Find an active branch of a corporation that matches the user's coordinates.
     * Throws an exception if no matching branch is found within geofence radius.
     */
    public function validateAndFindBranch(Corporation $corporation, float $latitude, float $longitude, float $accuracy): Branch
    {
        // Accuracy threshold check (e.g. reject GPS accuracy worse than 100 meters)
        if ($accuracy > 100.0) {
            throw new BusinessRuleViolationException(
                "GPS signal accuracy is too poor ({$accuracy}m). Please try from a different location.",
                'POOR_GPS_ACCURACY'
            );
        }

        // Fetch all active branches for this corporation
        $branches = Branch::where('corporation_id', $corporation->id)
            ->where('is_active', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        foreach ($branches as $branch) {
            $branchLat = (float) $branch->latitude;
            $branchLng = (float) $branch->longitude;
            $radius = (int) ($branch->geo_fence_radius ?? 200); // Default to 200 meters if not set

            $distance = $this->calculateDistance($latitude, $longitude, $branchLat, $branchLng);

            if ($distance <= $radius) {
                return $branch;
            }
        }

        throw new BusinessRuleViolationException(
            'You are outside the permitted geo-fenced work locations.',
            'OUTSIDE_GEOFENCE'
        );
    }
}
