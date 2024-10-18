<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional avatar upload validation
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('rules.Name_is_required'),
            'email.required' => __('rules.Email_is_required'),
            'email.email' => __('rules.Email_must_be_a_valid_email_address'),
            'email.unique' => __('rules.This_email_has_already_been_taken'),
            'password.required' => __('rules.Password_is_required'),
            'password.min' => __('rules.Password_must_be_at_least_8_characters'),
            'avatar.image' => __('rules.The_avatar_must_be_an_image_file'),
            'avatar.mimes' => __('rules.The_avatar_must_be_a_file_of_type_jpeg_png_jpg_gif'),
            'avatar.max' => __('rules.The_avatar_must_not_exceed_2MB'),
        ];
        
    }

    
}
