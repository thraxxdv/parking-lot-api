<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParkingSpace\ParkVehicleRequest;
use App\Http\Requests\ParkingSpace\UnparkVehicleRequest;
use App\Services\ParkingSpaceService;
use Illuminate\Http\Request;

class ParkingSpaceController extends Controller
{
    private $parkingSpaceService;

    public function __construct() {
        $this->parkingSpaceService = new ParkingSpaceService();
    }

    public function getParkingSpaces()
    {
        return response()->json($this->parkingSpaceService->getParkingSpaces());
    }

    public function createParkingSpace(Request $request)
    {
        $validated = $request->validate([ 'vehicle_type_id' => ['required', 'exists:vehicle_types,id'] ]);

        return response()->json($this->parkingSpaceService->createNewParkingSpace($validated['vehicle_type_id']), 201);
    }

    public function parkVehicle(ParkVehicleRequest $request)
    {
        $validated = $request->validated();

        return $this->parkingSpaceService->parkVehicle($validated['gate'], !empty($validated['uuid']) ? $validated['uuid'] : null, $validated['vehicle_type_id'], $validated['timestamp']);
    }

    public function unparkVehicle(UnparkVehicleRequest $request)
    {
        $validated = $request->validated();

         return response()->json($this->parkingSpaceService->unparkVehicle($validated['uuid'], $validated['timestamp']));


    }
}
