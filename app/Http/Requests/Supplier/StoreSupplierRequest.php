<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Customize the error messages based on the specific validation rules.
     */
    public function messages() {
        return [
            'phone.regex' => 'The phone number must have a prefix of 62.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'regex:/^62\d+$/'], // Regex means phone number must start with 62 and followed by 1-9 digits.
            'note' => ['nullable', 'string'],
        ];
    }
}
