<?php

namespace App\Rules\ParkingSpace;

use App\Models\ParkingSpace;
use Illuminate\Contracts\Validation\Rule;

class ParkingNotFull implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Check if there is an available parking space for the vehicle type
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ParkingSpace::where(
            [
                ['vehicle_type_id', '>=', $value],
                ['is_occupied', 0]
            ]
        )->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There are no longer any parking space available for your vehicle type.';
    }
}
