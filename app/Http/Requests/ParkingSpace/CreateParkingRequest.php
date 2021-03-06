<?php

namespace App\Http\Requests\ParkingSpace;

use Illuminate\Foundation\Http\FormRequest;

class CreateParkingRequest extends FormRequest
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
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id']
        ];
    }
}
