<?php

namespace App\Actions\ParkingSpaceActions;

use App\Models\VehicleType;
use App\Utilities\DateUtilities;

class ComputeParkingFee
{

    private float $flatRate = 40;
    private float $chunkRate = 5000;

    /**
     * Entry (handle) method for computing parking fee
     *
     * @param string $parkedOn Timestamp on when the vehicle parks
     * @param string $leftOn Timestamp on when the vehicle unparks
     * @param integer $vehicleType The vehicle type for the parking space
     * @return float Calculated fee
     */
    public function handle(string $parkedOn, string $leftOn, int $vehicleType) : float
    {
        $dateUtilities = new DateUtilities();
        $hours = ceil($dateUtilities->getTimeDifference($parkedOn, $leftOn) / 60);

        return $this->calculateFee($hours, $vehicleType);
    }

    /**
     * Calculates fees including parking within 24 hours
     * and chunk rates
     *
     * @param integer $totalHours Total hours parked
     * @param integer $vehicleTypeId The vehicle type for the parking space
     * @return float Calculated fee
     */
    private function calculateFee(int $totalHours, int $vehicleTypeId) : float
    {
        $flatRate = 0;
        $vehicleRate = 0;
        $chunkRate = 0;
        if ($totalHours <= 24) {
            $hours = $this->filter24Hours($totalHours);
            $flatRate = $this->calculateFlatRate($hours['flat_rate_hours']);
            $vehicleRate = $this->calculateVehicleRate($hours['vehicle_rate_hours'], $vehicleTypeId);
        } else {
            $hours = $this->filterChunkRate($totalHours);
            $flatRate = $this->calculateFlatRate($hours['flat_rate_hours']);
            $vehicleRate = $this->calculateVehicleRate($hours['vehicle_rate_hours'], $vehicleTypeId);
            $chunkRate = $this->calculateChunkRate($hours['chunk_multiplier']);
        }

        return $flatRate + $vehicleRate + $chunkRate;
    }

    /**
     * Calculates the flat rate
     *
     * @param integer $hours Hours applicable to flat rate
     * @return float
     */
    private function calculateFlatRate(int $hours) : float
    {
        return $this->flatRate * $hours;
    }

    /**
     * Calculates the parking space specific rate by getting
     * rates from the database and multiplying it by the
     * applicable hours
     *
     * @param integer $hours Hours applicable for parking space specific rate
     * @param integer $vehicleTypeId The vehicle type for the parking space
     * @return float Calculated rate for the vehicle type
     */
    private function calculateVehicleRate(int $hours, int $vehicleTypeId) : float
    {
        $vehicleType = VehicleType::find($vehicleTypeId);

        return $vehicleType->rate * $hours;
    }

    /**
     * Takes a multiplier as an argument and
     * multiplies that by the chunk rate
     *
     * @param integer $multiplier
     * @return float
     */
    private function calculateChunkRate(int $multiplier) : float
    {
        return $multiplier * $this->chunkRate;
    }

    /**
     * Returns an array that has computed the applicable hours
     * for flat rate and parking space specific rates
     *
     * @param integer $hours
     * @return array
     */
    private function filter24Hours(int $hours) : array
    {
        $flatHours = 0;
        $vehicleHours = 0;
        if ($hours > 3) {
            $flatHours = 3;
            $vehicleHours = $hours - 3;
        } else {
            $flatHours = $hours;
        }

        return [
            'flat_rate_hours' => $flatHours,
            'vehicle_rate_hours' => $vehicleHours
        ];
    }

    /**
     * Returns an array that has compute the applicable hours
     * for flat rate, parking space specific rates as well as
     * the chunk rate. This method re-uses the `filter24Hours($hours)`
     * method
     *
     * @param integer $hours
     * @return array
     */
    public function filterChunkRate(int $hours) : array
    {
        $chunkableMultiplier = floor($hours / 24);
        $remainingHours = $hours - ($chunkableMultiplier * 24);
        $calcs = $this->filter24Hours($remainingHours);
        $calcs['chunk_multiplier'] = $chunkableMultiplier;
        return $calcs;
    }
}
