<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSkillRequest extends FormRequest
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
            'position' => 'required',
            'work_place' => 'required',
            'work_now' => 'required|in:0,1',
            'start_at' => 'required|date_format:Y-m-d',
            'end_at' => 'nullable|required_if:work_now,0|date_format:Y-m-d|after:start_at',
            'end_reasons' => 'nullable|required_if:work_now,0',
        ];
    }
}
