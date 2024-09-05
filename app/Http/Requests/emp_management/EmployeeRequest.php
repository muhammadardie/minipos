<?php

namespace App\Http\Requests\emp_management;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
        $id = ($this->employee) ? $this->employee : 0;

        $rules = [
            'first_name'  => $id == 0 ?
                ['required','bail', 'max:100', 'unique:employees,first_name,'.$id.',id,deleted_at,NULL'] :
                ['no_js_validation', 'required','bail', 'max:100', 'unique:employees,first_name,'.$id.',id,deleted_at,NULL'],
            'last_name'   => ['nullable', 'max:100'],
            'birth_place' => ['required', 'max:100'],
            'birth_date'  => 'required|date_format:"'.\Helper::date_formats('', 'date_php').'"',
            'email'       => $id == 0 ?
                ['required','bail', 'max:100', 'unique:employees,email,'.$id.',id,deleted_at,NULL'] :
                ['no_js_validation', 'required','bail', 'max:100', 'unique:employees,email,'.$id.',id,deleted_at,NULL'],
            'photo'       => ['max:2000','mimes:jpg,jpeg,png'],
            'identity'    => ['required', 'integer', 'min:0'],
            'outlet'      => ['required', 'integer', 'min:0'],
            'identity_no' => ['required', 'max:30'],
            'last_name'   => [ 'max:100', 'nullable'],
            'is_active'   => ['required', 'integer', 'min:0', 'max:1'],
        ];

        return $rules;
    }

}
