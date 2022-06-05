<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class JobOfferRequest extends FormRequest
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
            'name' => 'required',
            'job_uuid' => 'required',
            'position_id' => 'required|exists:positions,id',
            'degree_id' => 'required|exists:degrees,id',
            'start_at' => 'required',
            'end_at' => 'required|after:start_at',
            'publish_at' => 'required',
            'tags' => 'nullable',
            'content' => 'nullable',
            'functional_terms' => 'nullable',
            'functional_tasks' => 'nullable',
            'gender' => 'required|in:0,male,female',
            'family_of_prisoners' => 'required|in:0,1,2',
            'injured_people' => 'required|in:0,1,2',
            'family_of_martyrs' => 'required|in:0,1,2',
            'governorates' => 'nullable|array',
            'languages' => 'nullable|array',
            'disabilities' => 'nullable|array',
            'qualifications' => 'nullable|array',
            'sub_degrees' => 'nullable|array',
            'ministries' => 'nullable|array',
        ];
    }
}
