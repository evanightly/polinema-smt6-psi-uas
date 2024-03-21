<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'stock' => $this->stock,
            'restock_threshold' => $this->restock_threshold,
            'min_stock' => $this->min_stock,
            'max_stock' => $this->max_stock,
            'supplier' => new SupplierResource($this->whenLoaded('supplier')),
            'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
            'can_be_deleted' => $this->canBeDeleted(),
            'needs_restock' => $this->needsRestock(),
        ];
    }
}
