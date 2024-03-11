<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest {
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'restock_threshold' => ['required', 'numeric'],
            'min_stock' => ['required', 'numeric'],
            'max_stock' => ['required', 'numeric'],
            'supplier_id' => ['required', 'numeric'],
        ];
    }
}
