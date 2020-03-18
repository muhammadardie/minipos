<?php

namespace App\Http\Requests\purchasing;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

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
        ];

        return $returns;
    }
}
