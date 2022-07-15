<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        $rules = [];
        $rules["question"] = 'required';
        $rules['option'] = 'nullable|array';
        $rules['option.*'] = 'required|string';
        $rules['old_option'] = 'nullable|array';
        $rules['old_option.*'] = 'required|string';
        $rules['type'] = 'required|in:radio,checkbox,writing,file';

        return $rules;
    }
}
