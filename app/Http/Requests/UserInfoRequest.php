<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
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
            'full_name' => 'required',
            'uid' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date_format:Y-m-d',
            'marital_status' => 'required',
            'number_of_children' => 'required|min:0',
            'number_of_employees' => 'required|min:0',
            'scholarship_student' => 'required',
            'top_ten_students' => 'required',
            'birth_governorate_id' => 'required|exists:governorates,id',
            'governorate_id' => 'required|exists:governorates,id',
            'address' => 'required|string',
            'unemployed' => 'required',
            'work_nonGovernmental_org' => 'required',
            'registered_unemployed_ministry' => 'required',
            'family_of_prisoners' => 'required',
            'injured_people' => 'required',
            'family_of_martyrs' => 'required',
        ];
    }
}
