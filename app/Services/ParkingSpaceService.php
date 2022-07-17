<?php

namespace App\Services;

use App\Models\ParkingSpace;

class ParkingSpaceService
{
    public function createNewParkingSpace(string $vehicleTypeId)
    {

        try {
            $parkingSpace = new ParkingSpace();
            $parkingSpace->vehicle_type_id = $vehicleTypeId;
            $parkingSpace->save();
            return $parkingSpace;
        } catch (\Throwable $th) {
            abort(500);
        }
    }
}
