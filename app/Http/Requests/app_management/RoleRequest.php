<?php

namespace App\Http\Requests\app_management;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'name'          => ['required','bail','alpha_dash', 'max:50'],
            'description'   => 'max:255'
        ];
    }

    public function messages()
    {
        return [
            // 'nama_role.required' => 'Nama role tidak boleh kosong',
        ];
    }
}
