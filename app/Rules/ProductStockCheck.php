<?php

namespace App\Rules;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductStockCheck implements ValidationRule {

    private $productId;
    private $quantity;

    public function __construct(int $productId, int $quantity) {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        $productRepository = new ProductRepository();
        $product = $productRepository->get(['filters' => ['id' => $this->productId]])->first();
        if (!$product || $product->stock < $this->quantity) {
            $fail('The selected product does not have enough stock.');
        }
    }
}
