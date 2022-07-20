<?php

namespace App\Services;

use App\Actions\ParkingSpaceActions\ComputeParkingFee;
use App\Actions\ParkingSpaceActions\GetClosestParkingSpaceFromGate;
use App\Models\Gate;
use App\Models\ParkingSpace;
use App\Utilities\DateUtilities;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ParkingSpaceService
{

    /**
     * Returns a collection of all parking spaces in the database
     *
     * @return ParkingSpace
     */
    public function getParkingSpaces(): Collection
    {
        return ParkingSpace::with('gate', 'vehicleType')->get();
    }

    /**
     * Creates a new parking space in the database and returns the created instance
     *
     * @param string $vehicleTypeId
     * @return ParkingSpace
     */
    public function createNewParkingSpace(string $vehicleTypeId): ParkingSpace
    {
        $parkingSpace = new ParkingSpace();
        $parkingSpace->vehicle_type_id = $vehicleTypeId;
        $parkingSpace->save();
        return $parkingSpace;
    }

    /**
     * Parks vehicle by updating specified parking space in the database with a uuid for the vehicle
     * and marking it as occupied. Takes into account a continuous rate if vehicle has came back within an hour to re-park.
     *
     * @param int $gateId The gate ID / gate # where the vehicle is coming in. ID number is not necessarily near the the corresponding parking space ID
     * @param string|null $vehicleId (Optional) A uuid of the vehicle as a reference for a vehicle that is coming back
     * @param integer $vehicleTypeId The vehicle type ID of the vehicle type coming into the parking space
     * @param string $timestamp Manually inputted timestamp of when the vehicle has parked
     * @return ParkingSpace 
     */
    public function parkVehicle(int $gateId, string | null $vehicleId = null, int $vehicleTypeId, string $timestamp): ParkingSpace
    {
        $gate = Gate::find($gateId);
        $diff = null;

        if (!empty($vehicleId) && ParkingSpace::where('vehicle_id', $vehicleId)->exists()) {
            $dateUtils = new DateUtilities();

            $existingSession = ParkingSpace::where([
                ['vehicle_id', $vehicleId],
                ['is_occupied', 0]
            ])->first();

            $diff = empty($existingSession) ? $diff : $dateUtils->getTimeDifference($existingSession->left_on, $timestamp);
        }

        if (!empty($diff) && $diff <= 60) {
            $parkingSpace = $existingSession;
        } else {

            $getClosestParkingSpaceFromGate = new GetClosestParkingSpaceFromGate();
            $parkingSpace = $getClosestParkingSpaceFromGate->handle($gate->nearest_space, $vehicleTypeId);
        }

        $parkingSpace->is_occupied = 1;
        $parkingSpace->occupying_vehicle_type = !empty($diff) ? $existingSession->occupying_vehicle_type : $vehicleTypeId;
        $parkingSpace->vehicle_id = !empty($diff) ? $existingSession->vehicle_id : Str::uuid();
        $parkingSpace->parked_on = !empty($diff) ? $existingSession->parked_on : $timestamp;
        $parkingSpace->save();

        return $parkingSpace;
    }

    /**
     * Unparks vehicle by uuid
     *
     * @param string $uuid Uuid of the parked vehicle
     * @param string $timestamp Manually inputted timestamp of when the vehicle will unpark
     * @return ParkingSpace
     */
    public function unparkVehicle(string $uuid, string $timestamp): ParkingSpace
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