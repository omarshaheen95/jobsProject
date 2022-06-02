<?php

namespace App\Http\Requests\manager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ManagerRequest extends FormRequest
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
        if (Route::currentRouteName() == 'manager.manager.edit' || Route::currentRouteName() == 'manager.manager.update') {
            $user = $this->route('manager');
            return [
                'name' => 'required',
                'email' => "required|email|unique:managers,email,$user->id,id,deleted_at,NULL",
            ];
        }else{
            return [
                'name' => 'required',
                'email' => 'required|email|unique:managers,email,{$id},id,deleted_at,NULL',
                'password' => 'required'
            ];
        }
    }
}
