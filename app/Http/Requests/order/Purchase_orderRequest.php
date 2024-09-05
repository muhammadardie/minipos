<?php

namespace App\Http\Requests\order;

use Illuminate\Foundation\Http\FormRequest;

class Purchase_orderRequest extends FormRequest
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
        $returns = [
            'po_code'   => ['required'],
            'supplier'  => ['required'],
            'product.*' => ['required'],
            'qty.*'     => ['required']
        ];

        return $returns;
    }
}
