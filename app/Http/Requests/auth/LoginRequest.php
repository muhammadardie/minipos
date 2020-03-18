<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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

        $returns   = array();
        if ($this->isMethod('post')) {
            $returns = [
                'email'=> 'required|email|min:6',
                'password'=> 'required|min:6|max:255',
  
            ];
        } // update data (backend validation)
        elseif ($this->isMethod('patch')) {
            $returns = [
                'email'=> 'required|email|min:6',
                'password'=> 'required|min:6|max:255',
            ];

            // if not empty password, then set validation password (if user input new password)
        } else {
            $returns = [
                'email'=> 'required|email|min:6',
                'password'=> 'required|min:6|max:255',
            ];
        }

        return $returns;
    }
}
