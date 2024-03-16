<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateProductQuantity {
    protected $productRepository;

    /**
     * Create the event listener.
     */
    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionCreated $event): void {
        foreach ($event->transaction->products as $product) {
            $newQuantity = $product->stock - $product->pivot->quantity;
            $productInstance = $this->productRepository->get(['filters' => ['id' => $product->id]])->first();
            $this->productRepository->update($productInstance, ['stock' => $newQuantity]);
        }
    }
}
