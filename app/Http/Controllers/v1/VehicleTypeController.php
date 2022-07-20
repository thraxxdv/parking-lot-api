<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\VehicleTypeService;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{

    private $vehicleTypeService;

    public function __construct() {
        $this->vehicleTypeService = new VehicleTypeService();
    }

    public function getVehicleTypes()
    {
        return response()->json($this->vehicleTypeService->getTypes());
    }
}
