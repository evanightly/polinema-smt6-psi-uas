<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'product_id' => $this->product_id,
            'buyer_name' => $this->buyer_name,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'price_total' => $this->price_total,
            'transaction_date' => $this->transaction_date,
            'formatted_transaction_date' => $this->formattedTransactionDate,
            'has_related_models' => $this->user()->exists() && $this->products->isNotEmpty(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
