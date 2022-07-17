<?php

namespace App\Http\Requests\ParkingSpace;

use Illuminate\Foundation\Http\FormRequest;

class UnparkVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [ 
            'uuid' => ['required', 'uuid', 'exists:parking_spaces,vehicle_id'],
            'timestamp' => ['required', 'date']
        ];
    }
}
