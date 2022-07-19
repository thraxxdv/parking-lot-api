<?php

namespace App\Rules\ParkingSpace;

use App\Models\ParkingSpace;
use Illuminate\Contracts\Validation\Rule;

/**
 * Checks if the unpark time is after parking time.
 */
class UnparkTimeAfterParkingTime implements Rule
{
    
    private $parkingSpace;
    public function __construct(string $uuid)
    {
        $this->parkingSpace = ParkingSpace::where('vehicle_id', $uuid)->firstOrFail();
    }
    
    public function passes($attribute, $value)
    {
        return $this->parkingSpace->parked_on < $value;
    }
    
    public function message()
    {
        return 'Unpark time must be after parking time. You have parked on ' . $this->parkingSpace->parked_on . ".";
    }
}
