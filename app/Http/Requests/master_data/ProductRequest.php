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

        $returns = array();
        if ($this->isMethod('post')) {
            $returns = [
                'product_category' => ['required', 'integer', 'min:0'],
                'brand'            => ['required', 'integer', 'min:0'],
                'unit'             => ['required', 'integer', 'min:0'],
                'supplier'         => ['required', 'integer', 'min:0'],
                'name'             => ['required','bail', 'max:100', 'unique:products,name,'.$id.',id,deleted_at,NULL'],
                'code'             => ['required','alpha_num', 'max:30', 'regex:/^\S*$/u','unique:products,code,'.$id.',id,deleted_at,NULL'],
                'cost'             => ['required'],
                'release_date'     => ['required','date_format:"'.\Helper::date_formats('', 'date_php').'"'],
                'price'            => ['required'],
                'storage'          => ['nullable','max:255'],
                'image'            => ['max:2000','mimes:jpg,jpeg,png'],
                'description'      => ['max:255'],
            ];
        } // update data (backend validation)
        elseif ($this->isMethod('patch')) {
            $returns = [
                'product_category' => ['required', 'integer', 'min:0'],
                'brand'            => ['required', 'integer', 'min:0'],
                'unit'             => ['required', 'integer', 'min:0'],
                'supplier'         => ['required', 'integer', 'min:0'],
                'name'             => ['required','bail', 'max:100', 'unique:products,name,'.$id.',id,deleted_at,NULL'],
                'code'             => ['required','alpha_num', 'max:30', 'regex:/^\S*$/u','unique:products,code,'.$id.',id,deleted_at,NULL'],
                'cost'             => ['required'],
                'release_date'     => ['required','date_format:"'.\Helper::date_formats('', 'date_php').'"'],
                'price'            => ['required'],
                'storage'          => ['nullable','max:255'],
                'image'            => ['max:2000','mimes:jpg,jpeg,png'],
                'description'      => ['max:255'],
            ];

        } else {
            $returns = [
                'product_category' => ['required', 'integer', 'min:0'],
                'brand'            => ['required', 'integer', 'min:0'],
                'unit'             => ['required', 'integer', 'min:0'],
                'supplier'         => ['required', 'integer', 'min:0'],
                'name'             => ['required','bail', 'max:100', 'unique:products,name,'.$id.',id,deleted_at,NULL'],
                'code'             => ['required','alpha_num', 'max:30', 'regex:/^\S*$/u','unique:products,code,'.$id.',id,deleted_at,NULL'],
                'cost'             => ['required'],
                'release_date'     => ['required','date_format:"'.\Helper::date_formats('', 'date_php').'"'],
                'price'            => ['required'],
                'storage'          => ['nullable','max:255'],
                'image'            => ['max:2000','mimes:jpg,jpeg,png'],
                'description'      => ['max:255'],
            ];
        }

        return $returns;
    }

}
