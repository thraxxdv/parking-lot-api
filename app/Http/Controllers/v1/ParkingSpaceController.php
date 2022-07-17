<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Rules\ParkingNotFull;
use App\Services\ParkingSpaceService;
use Illuminate\Http\Request;

class ParkingSpaceController extends Controller
{
    private $parkingSpaceService;

    public function __construct() {
        $this->parkingSpaceService = new ParkingSpaceService();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([ 'vehicle_type_id' => ['required', 'exists:vehicle_types,id'] ]);

        return response()->json($this->parkingSpaceService->createNewParkingSpace($validated['vehicle_type_id']), 201);
    }

    public function parkVehicle(Request $request)
    {
        $validated = $request->validate([
            'gate' => ['required', 'exists:gates,id'],
            'uuid' => ['nullable', 'uuid', 'exists:parking_spaces,vehicle_id'],
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id', new ParkingNotFull],
            'timestamp' => ['required', 'date']
        ]);

        return $this->parkingSpaceService->parkVehicle($validated['gate'], !empty($validated['uuid']) ? $validated['uuid'] : null, $validated['vehicle_type_id'], $validated['timestamp']);
    }

    public function unparkVehicle(Request $request)
    {
        $validated = $request->validate([ 
            'uuid' => ['required', 'uuid', 'exists:parking_spaces,vehicle_id'],
            'timestamp' => ['required', 'date']
         ]);

         return response()->json($this->parkingSpaceService->unparkVehicle($validated['uuid'], $validated['timestamp']));


    }
}
