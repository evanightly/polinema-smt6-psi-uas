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

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            if ($this->stock > $this->max_stock) {
                $validator->errors()->add('stock', 'The stock quantity cannot exceed the max stock.');
            }

            // if ($this->min_stock > $this->stock) {
            //     $validator->errors()->add('min_stock', 'The min stock quantity cannot exceed the stock.');
            // }

            if ($this->min_stock > $this->max_stock) {
                $validator->errors()->add('min_stock', 'The min stock quantity cannot exceed the max stock.');
            }
        });
    }
}
