<?php

namespace App\Http\Requests\ParkingSpace;

use App\Rules\ParkingSpace\IsVehicleIdInSpace;
use App\Rules\UnparkTimeAfterParkingTime;
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
            'uuid' => ['required', 'uuid', 'exists:parking_spaces,vehicle_id', new IsVehicleIdInSpace(true)],
            'timestamp' => ['required', 'date', new UnparkTimeAfterParkingTime($this->input('uuid'))]
        ];
    }
}
