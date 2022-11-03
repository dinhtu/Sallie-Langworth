<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => [
                'nullable',
                'max:15',
                'min:8',
                'regex:/^[A-Za-z0-9]*$/',
                'same:password_confirmation'
            ],
            'password_confirmation' => 'nullable'
        ];
    }
}
