<?php

namespace App\Rules\ParkingSpace;

use App\Models\ParkingSpace;
use Illuminate\Contracts\Validation\Rule;

/**
 * Checks if the vehicle ID is already parked. The parameter
 * `$inverseResult` can be set to true. If set to true, it checks
 * if the vehicle ID has already unparked in the space.
 */
class IsVehicleIdInSpace implements Rule
{
    
    private $inverseResult;
    private $inSpace;
    public function __construct($inverseResult = false)
    {
        $this->inverseResult = $inverseResult;
    }

    public function passes($attribute, $value)
    {
        $this->inSpace = ParkingSpace::where([
            ['vehicle_id', $value],
            ['is_occupied', 1]
        ])->exists();

        return $this->inverseResult ? $this->inSpace : !$this->inSpace;
    }

    public function message()
    {
        return $this->inSpace ? "This vehicle is already parked here." : "This vehicle has already unparked here";
    }
}
