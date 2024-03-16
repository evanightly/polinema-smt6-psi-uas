<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest {
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'buyer_name' => ['nullable', 'string', 'max:255'],
            'price_total' => ['required', 'numeric'],
            'products' => ['required', 'array'], // This is the array of products that will be added to the transaction
        ];
    }
}
