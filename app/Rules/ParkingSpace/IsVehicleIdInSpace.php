<?php

namespace App\Rules\ParkingSpace;

use App\Models\ParkingSpace;
use Illuminate\Contracts\Validation\Rule;

class IsVehicleIdInSpace implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $inverseResult;
    private $inSpace;
    public function __construct($inverseResult = false)
    {
        $this->inverseResult = $inverseResult;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->inSpace = ParkingSpace::where([
            ['vehicle_id', $value],
            ['is_occupied', 1]
        ])->exists();

        return $this->inverseResult ? $this->inSpace : !$this->inSpace;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->inSpace ? "This vehicle is already parked here." : "This vehicle has already unparked here";
    }
}
