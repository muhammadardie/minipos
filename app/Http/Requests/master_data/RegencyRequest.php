<?php

namespace App\Http\Requests\master_data;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class RegencyRequest extends FormRequest
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
        $regency_id = ($this->regency) ? $this->regency : 0;

        $returns = array();
        if ($this->isMethod('post')) {
            $returns = [
                'name'        => ['required','bail', 'max:100', 'unique:regencies,name,'.$regency_id.',id,deleted_at,NULL'],
                'province'    => ['required', 'integer', 'min:1'],
                'description' => ['max:255'],
            ];
        } // update data (backend validation)
        elseif ($this->isMethod('patch')) {
            $returns = [
                'name'        => ['required','bail', 'max:100', 'unique:regencies,name,'.$regency_id.',id,deleted_at,NULL'],
                'province'    => ['required', 'integer', 'min:1'],
                'description' => ['max:255'],
            ];

            // if not empty password, then set validation password (if user input new password)
        } else {
            $returns = [
                'name'        => 'required|bail|string|max:100|unique:regencies,name,'.$regency_id.',id,deleted_at,NULL',
                'province'    => ['required', 'integer', 'min:1'],
                'description' => 'max:255',
            ];
        }

        return $returns;
    }
}
