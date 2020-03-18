<?php

namespace App\Http\Requests\app_management;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class Edit_passwordRequest extends FormRequest
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
        $returns = array();

        // create data (backend validation)
        if($this->isMethod('post')){
            $returns = [
                'password'  => 'required|string|min:6|confirmed',
            ];
        }
        // update data (backend validation)
        else if($this->isMethod('patch')){
            $returns = [
                'password'  => 'required|string|min:6|confirmed',
            ];
        }else{
            $returns = [
                'password'  => 'required|string|min:6|confirmed',
            ];
        }

        return $returns;
    }
}