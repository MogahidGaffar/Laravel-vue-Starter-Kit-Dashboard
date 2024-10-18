<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name,' . $this->role->id // Allow the current role's name
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('rules.Role_name_is_required'),
            'name.unique' => __('rules.This_role_name_has_already_been_taken'),
            'name.string' => __('rules.Role_name_must_be_a_string'),
            'name.max' => __('rules.Role_name_must_not_exceed_255_characters'),
        ];
    }
}
