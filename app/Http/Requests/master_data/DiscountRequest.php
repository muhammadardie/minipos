<?php

namespace App\Http\Requests\master_data;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
        $id         = ($this->discount) ? $this->discount : 0;
        $returns    = array();
        if ($this->isMethod('post')) {
            $returns = [
                'discount_type'  => ['required','integer','min:1'],
                'name'           => ['required','bail', 'max:150','unique:discounts,name,'.$id.',id,deleted_at,NULL'],
                'code'           => ['required','alpha_num', 'max:30', 'regex:/^\S*$/u','unique:discounts,code,'.$id.',id,deleted_at,NULL'],
                // discount per item order
                'discount_model' => ['required_if:discount_type,1', 'min:0', 'max:1'],
                'nominal'        => ['required_if:discount_model,2'],
                'percent'        => ['required_if:discount_model,1'],
                // discount buy n' get
                'buy_product'    => ['required_if:discount_type,2'],
                'buy_qty'        => ['required_if:discount_type,2'],
                'get_product'    => ['required_if:discount_type,2'],
                'get_qty'        => ['required_if:discount_type,2'],
                'remark'         => ['max:255']
            ];
        } 
        elseif ($this->isMethod('patch')) {
            $returns = [
                'discount_type'  => ['required','integer','min:1'],
                'name'           => ['required','bail', 'max:150','unique:discounts,name,'.$id.',id,deleted_at,NULL'],
                'code'           => ['required','alpha_num', 'max:30', 'regex:/^\S*$/u','unique:discounts,code,'.$id.',id,deleted_at,NULL'],
                // discount per item order
                'discount_model' => ['required_if:discount_type,1', 'min:0', 'max:1'],
                'nominal'        => ['required_if:discount_model,2'],
                'percent'        => ['required_if:discount_model,1'],
                // discount buy n' get
                'buy_product'    => ['required_if:discount_type,2'],
                'buy_qty'        => ['required_if:discount_type,2'],
                'get_product'    => ['required_if:discount_type,2'],
                'get_qty'        => ['required_if:discount_type,2'],
                'remark'         => ['max:255']
            ];

        } else {
            $returns = [
                'discount_type'  => ['required','integer','min:1'],
                'name'           => ['required','bail', 'max:150','unique:discounts,name,'.$id.',id,deleted_at,NULL'],
                'code'           => ['required','alpha_num', 'max:30', 'regex:/^\S*$/u','unique:discounts,code,'.$id.',id,deleted_at,NULL'],
                // discount per item order
                'discount_model' => ['required_if:discount_type,1', 'min:0', 'max:1'],
                'nominal'        => ['required_if:discount_model,2'],
                'percent'        => ['required_if:discount_model,1'],
                // discount buy n' get
                'buy_product'    => ['required_if:discount_type,2'],
                'buy_qty'        => ['required_if:discount_type,2'],
                'get_product'    => ['required_if:discount_type,2'],
                'get_qty'        => ['required_if:discount_type,2'],
                'remark'         => ['max:255']
            ];
        }

        return $returns;
    }
}
