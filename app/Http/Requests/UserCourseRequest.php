<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCourseRequest extends FormRequest
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
            'course_name' => 'required',
            'course_place' => 'required',
            'course_hours' => 'required',
            'start_at' => 'required|date_format:Y-m-d',
            'end_at' => 'required|date_format:Y-m-d|after:start_at',
        ];
    }
}
