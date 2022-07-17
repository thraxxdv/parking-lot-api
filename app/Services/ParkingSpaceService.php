<?php

namespace App\Services;

use App\Actions\ParkingSpaceActions\GetClosestParkingSpaceFromGate;
use App\Models\Gate;
use App\Models\ParkingSpace;
use App\Utilities\Utilities;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ParkingSpaceService
{
    public function createNewParkingSpace(string $vehicleTypeId) : ParkingSpace
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

    public function parkVehicle(int $gateId, string | null $vehicleId = null, int $vehicleTypeId) : ParkingSpace
    {
        $getClosestParkingSpaceFromGate = new GetClosestParkingSpaceFromGate(); 
        $gate = Gate::find($gateId);
        $parkingSpace = $getClosestParkingSpaceFromGate->handle($gate->nearest_space, $vehicleTypeId);
        $parkingSpace->is_occupied = 1;
        $parkingSpace->vehicle_id = Str::uuid();
        $parkingSpace->parked_on = now();
        $parkingSpace->save();
        return $parkingSpace;
    }
}
