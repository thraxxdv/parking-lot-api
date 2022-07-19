<?php

namespace App\Rules\Gate;

use App\Models\Gate;
use Illuminate\Contracts\Validation\Rule;

class IsNearestSpaceFromGateTaken implements Rule
{

    public function passes($attribute, $value)
    {
        return !Gate::where('nearest_space', $value)->exists();
    }
    
    public function message()
    {
        return 'There is already a gate in this space. Please choose another parking space.';
    }
}
