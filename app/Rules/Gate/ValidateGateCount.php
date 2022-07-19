<?php

namespace App\Rules\Gate;

use App\Models\Gate;
use Illuminate\Contracts\Validation\Rule;

/**
 * Checks if gate can be deleted, since it is a requirement that no less
 * than 3 gates can be present at a time
 */
class ValidateGateCount implements Rule
{
    
    public function passes($attribute, $value)
    {
        return Gate::count() == 3 ? false : true;
    }

    public function message()
    {
        return 'No more gates can be deleted because there can be no less than 3 gates at a time.';
    }
}
