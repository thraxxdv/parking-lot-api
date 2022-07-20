<?php

namespace App\Services;

use App\Models\VehicleType;

class VehicleTypeService {
    public function getTypes()
    {
        return VehicleType::get();
    }
}