<?php

namespace App\Http\Requests\master_data;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
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
        $id = ($this->brand) ? $this->brand : 0;

        $returns = array();
        if ($this->isMethod('post')) {
            $returns = [
                'name'   => ['required','bail', 'max:100', 'unique:brands,name,'.$id.',id'],
                'remark' => ['max:255'],
            ];
        } // update data (backend validation)
        elseif ($this->isMethod('patch')) {
            $returns = [
                'name'   => ['required','bail', 'max:100', 'unique:brands,name,'.$id.',id'],
                'remark' => ['max:255'],
            ];
            
        } else {
            $returns = [
                'name'   => 'required|bail|string|max:100|unique:brands,name,'.$id.',id',
                'remark' => 'max:255',
            ];
        }

        return $returns;
    }
}
