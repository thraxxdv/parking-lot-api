<?php

namespace App\Services;

use App\Models\Gate;
use App\Models\ParkingSpace;
use App\Utilities\Utilities;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ParkingSpaceService
{
    private $utilities;
    public function __construct() {
        $this->utilities = new Utilities();
    }

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
        $gate = Gate::find($gateId);
        $parkingSpace = $this->getClosestSpaceFromGate($gate->nearest_space, $vehicleTypeId);
        $parkingSpace->is_occupied = 1;
        $parkingSpace->vehicle_id = Str::uuid();
        $parkingSpace->parked_on = now();
        $parkingSpace->save();
        return $parkingSpace;
    }

    public function getClosestSpaceFromGate(int $nearestSpaceFromGate, int $vehicleTypeId) : ParkingSpace
    {
        // Get all unoccupied parking spaces that's compatible with vehicle type
        $parkingSpaces = ParkingSpace::select('id')->where([
            ['is_occupied', 0],
            ['vehicle_type_id', '>=', $vehicleTypeId]
        ])->get()->pluck('id');

        // If the nearest space is not taken, return that parking space. If taken, run alg and return closest parking space id
        $parkingSpaceId = $parkingSpaces->contains($nearestSpaceFromGate) ? $nearestSpaceFromGate : $this->utilities->getClosestNumber($nearestSpaceFromGate, $parkingSpaces);

        return ParkingSpace::find($parkingSpaceId);
    }
}
