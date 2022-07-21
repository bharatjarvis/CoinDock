<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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

            'first_name' => 'string|max:45',
            'date_of_birth'=>'date_format:d-m-Y',
            'last_name' => 'string|max:45',
            'country' => 'string',
            'title' => 'string',
            'password' => 'string|min:12|max:45',
            'primary_currency' => 'string',
            'secondary_currency' => 'string'
        ];
    }
}
