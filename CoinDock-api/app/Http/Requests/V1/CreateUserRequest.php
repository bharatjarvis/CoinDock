<?php

namespace App\Http\Requests\V1;

use App\Http\Requests\FormRequest;

class CreateUserRequest extends FormRequest
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
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'date_of_birth' => 'required|date|before_or_equal:'.\Carbon\Carbon::now()->subYears(15)->format('Y-m-d'),
            'country' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:45|min:12|',//regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
        ];
    }
}