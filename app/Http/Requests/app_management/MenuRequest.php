<?php

namespace App\Http\Requests\app_management;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
        return [
            'name'       => ['required', 'bail', 'max:50'],
            'folder'     => ['required', 'max:50'],
            'class'      => ['max:50'],
            'parent'     => ['integer', 'min:0'],
            'order'      => ['required', 'integer', 'min:1'],
            'icon_class' => ['max:50'],
            'active'     => ['required', 'integer', 'min:0', 'max:1'],
        ];
    }
}
