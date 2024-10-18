<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name', // Validate name field
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
