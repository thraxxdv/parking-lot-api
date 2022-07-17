<?php

namespace App\Http\Requests\ParkingSpace;

use App\Rules\ParkingNotFull;
use Illuminate\Foundation\Http\FormRequest;

class ParkVehicleRequest extends FormRequest
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
            'gate' => ['required', 'exists:gates,id'],
            'uuid' => ['nullable', 'uuid', 'exists:parking_spaces,vehicle_id'],
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id', new ParkingNotFull],
            'timestamp' => ['required', 'date']
        ];
    }
}