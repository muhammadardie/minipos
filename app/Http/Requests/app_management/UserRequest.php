<?php

namespace App\Http\Requests\app_management;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class UserRequest extends FormRequest
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
        $returns    = array();
        $user_id    = $this->user;

        // create data (backend validation)
        if($this->isMethod('post')){
            $returns = [
                'emp'                   => 'required|integer|min:1',
                'password'              => 'required|string|min:6|confirmed',
                'role'                  => 'required|integer|min:1',
            ];
        }
        // update data (backend validation)
        else if($this->isMethod('patch')){

            $returns = [
                'emp'       => 'required|integer|min:1',
                'role'      => 'required|integer|min:1',
            ];

            // if not empty password, then set validation password (if user input new password)
            if(!empty($this->password)){
                $returns['password'] = 'required|string|min:6|confirmed';
            }
        }else{

            // create/update data (frontend validation)

            $route_name     = explode('.', Route::currentRouteName());
            $route_len      = count($route_name);
            if(count($route_name) < 3) die('UserRequest: length route !=2 or !=3');

            // without isMethod()
            $returns = [
                'emp'       => 'required|integer|min:1',
                'role'      => 'required|integer|min:1',
            ];

            if($route_name[2] == 'create') $returns['password']  = 'required|string|min:6|confirmed';
        }

        return $returns;
    }
}