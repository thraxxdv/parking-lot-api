<?php

namespace App\Rules;

use App\Models\ParkingSpace;
use Illuminate\Contracts\Validation\Rule;

class UnparkTimeAfterParkingTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $parkingSpace;
    public function __construct(string $uuid)
    {
        $this->parkingSpace = ParkingSpace::where('vehicle_id', $uuid)->firstOrFail();
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
        return $this->parkingSpace->parked_on < $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Unpark time must be after parking time. You have parked on ' . $this->parkingSpace->parked_on . ".";
    }
}
