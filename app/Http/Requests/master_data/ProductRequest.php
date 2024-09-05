<?php

namespace App\Http\Requests\master_data;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $id = ($this->product) ? $this->product : 0;
        
        $rules = [
            'product_category' => ['required', 'integer', 'min:0'],
            'brand'            => ['required', 'integer', 'min:0'],
            'unit'             => ['required', 'integer', 'min:0'],
            'supplier'         => ['required', 'integer', 'min:0'],
            'name'             => $id == 0 ?
                ['required', 'bail', 'max:100', 'unique:products,name,'.$id.',id,deleted_at,NULL'] :
                ['required','no_js_validation', 'bail', 'max:100', 'unique:products,name,'.$id.',id,deleted_at,NULL'],
            'code'             =>  $id == 0 ?
                ['required', 'alpha_num', 'max:30', 'regex:/^\S*$/u','unique:products,code,'.$id.',id,deleted_at,NULL'] :
                ['required','no_js_validation', 'alpha_num', 'max:30', 'regex:/^\S*$/u','unique:products,code,'.$id.',id,deleted_at,NULL'],
            'cost'             => ['required'],
            'release_date'     => ['required','date_format:"'.\Helper::date_formats('', 'date_php').'"'],
            'price'            => ['required'],
            'storage'          => ['required','max:255'],
            'image'            => ['max:2000','mimes:jpg,jpeg,png'],
            'description'      => ['max:255'],
        ];

        return $rules;
    }

}
