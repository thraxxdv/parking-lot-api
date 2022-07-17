<?php

namespace App\Actions\ParkingSpaceActions;

use App\Models\ParkingSpace;
use App\Utilities\NumberUtilities;

class GetClosestParkingSpaceFromGate
{
    /**
     * Gets the closest available parking space for the vehicle coming in by getting all the available parking space
     * and determining the nearest space from the gate the vehicle has entered by
     *
     * @param integer $nearestSpaceFromGate ID of nearest parking space from the gate. Can only get this from the `gates` table
     * @param integer $vehicleTypeId The vehicle type coming in to the parking lot
     * @return ParkingSpace
     */
    public function handle(int $nearestSpaceFromGate, int $vehicleTypeId): ParkingSpace
    {
        $utilities = new NumberUtilities();
        
        $parkingSpaces = ParkingSpace::select('id')->where([
            ['is_occupied', 0],
            ['vehicle_type_id', '>=', $vehicleTypeId]
        ])->get()->pluck('id');

        $parkingSpaceId = $parkingSpaces->contains($nearestSpaceFromGate) ? $nearestSpaceFromGate : $utilities->getClosestNumber($nearestSpaceFromGate, $parkingSpaces);

        return ParkingSpace::find($parkingSpaceId);
    }
}
