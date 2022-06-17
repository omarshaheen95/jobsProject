<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserQualificationRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'nullable',
            'qualification_id' => 'required|exists:qualifications,id',
            'degree_id' => 'required|exists:degrees,id',
            'sub_degree_id' => 'required|exists:sub_degrees,id',
            'country_id' => 'required|exists:countries,id',
            'appreciation_id' => 'required|exists:appreciations,id',
            'graduation_place' => 'required',
            'average' => 'required',
            'graduation_date' => 'required|date_format:Y-m-d',
        ];
    }
}
