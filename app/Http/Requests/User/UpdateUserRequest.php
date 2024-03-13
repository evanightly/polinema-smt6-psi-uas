<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            // ensures that the 'role' field is present and is an array
            'roles' => 'required|array',

            // ensures that each value in the 'role' array is an integer and exists in the 'roles' table
            'roles.*' => 'required|integer|exists:roles,id',
        ];
    }
}
