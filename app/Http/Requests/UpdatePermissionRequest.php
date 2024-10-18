<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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
                'unique:permissions,name,' . $this->permission->id // Allow the current permission's name
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('rules.Permission_name_is_required'),
            'name.unique' => __('rules.This_permission_name_has_already_been_taken'),
            'name.string' => __('rules.Permission_name_must_be_a_string'),
            'name.max' => __('rules.Permission_name_must_not_exceed_255_characters'),
        ];
    }
}
