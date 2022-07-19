<?php

namespace App\Rules\Gate;

use App\Models\Gate;
use Illuminate\Contracts\Validation\Rule;

class ValidateGateCount implements Rule
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
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Gate::count() == 3 ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No more gates can be deleted because there can be no less than 3 gates at a time.';
    }
}
