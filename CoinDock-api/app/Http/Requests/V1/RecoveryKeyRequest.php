<?php

namespace App\Http\Requests\V1;

use App\Http\Requests\FormRequest;

class RecoveryKeyRequest extends FormRequest
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
        return  [
            'key_response' => 'required|array',
            'key_response.*' => 'required|string|max:6|min:4',

        ];
    }
}
