<?php

namespace App\Actions\ParkingSpaceActions;

use App\Models\VehicleType;
use App\Utilities\DateUtilities;
use Illuminate\Support\Facades\Log;

class ComputeParkingFee
{

    private float $flatRate = 40;
    private float $chunkRate = 5000;

    public function handle(string $parkedOn, string $leftOn, int $vehicleType)
    {
        $dateUtilities = new DateUtilities();
        $hours = ceil($dateUtilities->getTimeDifference($parkedOn, $leftOn) / 60);
        Log::debug($hours);
        return $this->calculateFee($hours, $vehicleType);
    }

    private function calculateFee(int $totalHours, int $vehicleTypeId)
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

    private function calculateFlatRate(int $hours)
    {
        return $this->flatRate * $hours;
    }

    private function calculateVehicleRate(int $hours, int $vehicleTypeId)
    {
        $vehicleType = VehicleType::find($vehicleTypeId);
        Log::debug($vehicleType);
        return $vehicleType->rate * $hours;
    }

    private function calculateChunkRate(int $multiplier)
    {
        return $multiplier * $this->chunkRate;
    }

    private function filter24Hours(int $hours)
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

    public function filterChunkRate(int $hours)
    {
        $chunkableMultiplier = floor($hours / 24);
        $remainingHours = $hours - ($chunkableMultiplier * 24);
        $calcs = $this->filter24Hours($remainingHours);
        $calcs['chunk_multiplier'] = $chunkableMultiplier;
        return $calcs;
    }
}
