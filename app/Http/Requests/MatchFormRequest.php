<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MatchFormRequest extends FormRequest
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
            'country_1' => [
                'required',
                Rule::in(Country::pluck('id')),
            ],
            'country_2' => [
                'required',
                Rule::in(Country::pluck('id')),
            ],
            'match_day' => 'required|date_format:Y/m/d H:i|after_or_equal:'.Carbon::now()->format('Y/m/d')
        ];
    }
}
