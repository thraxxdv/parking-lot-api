<?php

namespace App\Services;

use App\Models\ParkingSpace;
use Illuminate\Support\Str;

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

    public function parkVehicle(int $gateId, string | null $vehicleId = null, int $vehicleTypeId)
    {
        
    }
}
