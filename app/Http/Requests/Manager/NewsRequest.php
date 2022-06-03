<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class NewsRequest extends FormRequest
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
       if (in_array(Route::currentRouteName(), ['manager.news.store', 'manager.news.create']))
       {
           return [
               'title' => 'required',
               'sub_title' => 'nullable',
               'content' => 'required',
               'tags' => 'nullable',
               'image' => 'required|image',
           ];
       }else{
           return [
               'title' => 'required',
               'sub_title' => 'nullable',
               'content' => 'required',
               'tags' => 'nullable',
               'image' => 'nullable|image',
           ];
       }
    }
}
