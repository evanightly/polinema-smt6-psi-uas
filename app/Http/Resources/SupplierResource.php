<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'note' => $this->note,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'products_total' => $this->products->count(),
            'canBeDeleted' => $this->canBeDeleted(),
        ];
    }
}
