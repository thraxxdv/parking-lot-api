<?php

namespace App\Services;

use App\Actions\ParkingSpaceActions\ComputeParkingFee;
use App\Actions\ParkingSpaceActions\GetClosestParkingSpaceFromGate;
use App\Models\Gate;
use App\Models\ParkingSpace;
use App\Utilities\DateUtilities;
use App\Utilities\Utilities;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ParkingSpaceService
{
    public function createNewParkingSpace(string $vehicleTypeId) : ParkingSpace
    {
        $parkingSpace = new ParkingSpace();
        $parkingSpace->vehicle_type_id = $vehicleTypeId;
        $parkingSpace->save();
        return $parkingSpace;
    }

    public function parkVehicle(int $gateId, string | null $vehicleId = null, int $vehicleTypeId, string $timestamp) : ParkingSpace
    {
        $gate = Gate::find($gateId);
        $diff = null;

        // Check for existing session
        if (!empty($vehicleId)) {
            $dateUtils = new DateUtilities();

            $existingSession = ParkingSpace::where([
                ['vehicle_id', $vehicleId],
                ['is_occupied', 0]
            ])->first();

            $diff = empty($existingSession) ? $diff : $dateUtils->getTimeDifference($existingSession->left_on, $timestamp);
        }
        
        // Continue existing session if time difference is less than or equal to 60 minutes
        if (!empty($diff) && $diff <= 60) {
            $parkingSpace = $existingSession;
        } else {
            // else create a new session
            $getClosestParkingSpaceFromGate = new GetClosestParkingSpaceFromGate(); 
            $parkingSpace = $getClosestParkingSpaceFromGate->handle($gate->nearest_space, $vehicleTypeId);
        }

        $parkingSpace->is_occupied = 1;
        $parkingSpace->vehicle_id = !empty($diff) ? $existingSession->vehicle_id : Str::uuid();
        $parkingSpace->parked_on = !empty($diff) ? $existingSession->parked_on : $timestamp;
        $parkingSpace->save();

        return $parkingSpace;
    }

    public function unparkVehicle(string $uuid, string $timestamp)
    {
        $computeParkingFee = new ComputeParkingFee();

        $parkingSpace = ParkingSpace::where('vehicle_id', $uuid)->first();
        $parkingSpace->left_on = $timestamp;
        $parkingSpace->is_occupied = 0;
        $parkingSpace->save();

        $parkingSpace->fee = $computeParkingFee->handle($parkingSpace->parked_on, $parkingSpace->left_on, $parkingSpace->vehicle_type_id);
        return $parkingSpace;
    }
}
