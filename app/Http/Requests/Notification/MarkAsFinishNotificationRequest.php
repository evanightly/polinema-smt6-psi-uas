<?php

namespace App\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class MarkAsFinishNotificationRequest extends FormRequest {
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
            'created_at' => ['required', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
        ];
    }
}
