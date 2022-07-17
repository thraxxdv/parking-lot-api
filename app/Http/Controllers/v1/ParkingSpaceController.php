<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\ParkingSpaceService;
use Illuminate\Http\Request;

class ParkingSpaceController extends Controller
{
    private $parkingSpaceService;

    public function __construct() {
        $this->parkingSpaceService = new ParkingSpaceService();
    }

    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
        ]);

        return response()->json($this->parkingSpaceService->createNewParkingSpace($validated['vehicle_type_id']), 200);
    }
}
