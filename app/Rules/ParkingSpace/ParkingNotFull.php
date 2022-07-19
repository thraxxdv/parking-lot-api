<?php

namespace App\Rules\ParkingSpace;

use App\Models\ParkingSpace;
use Illuminate\Contracts\Validation\Rule;

class ParkingNotFull implements Rule
{
    
    public function passes($attribute, $value)
    {
        return ParkingSpace::where(
            [
                ['vehicle_type_id', '>=', $value],
                ['is_occupied', 0]
            ]
        )->exists();
    }
    
    public function message()
    {
        return 'There are no longer any parking space available for your vehicle type.';
    }
}
