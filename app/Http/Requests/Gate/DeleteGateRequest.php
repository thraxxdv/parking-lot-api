<?php

namespace App\Http\Requests\Gate;

use App\Rules\Gate\ValidateGateCount;
use Illuminate\Foundation\Http\FormRequest;

class DeleteGateRequest extends FormRequest
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
            'nearest_space' => [ 'exists:gates,nearest_space', new ValidateGateCount ]
        ];
    }
}
