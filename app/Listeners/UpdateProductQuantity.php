<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Models\User;
use App\Notifications\ProductNeedsRestock;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

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
            $this->updateProductQuantity($product);
            $this->checkAndNotifyForRestock($product);
        }
    }

    private function updateProductQuantity($product): void {
        $newQuantity = $product->stock - $product->pivot->quantity;
        $productInstance = $this->productRepository->get(['filters' => ['id' => $product->id]])->first();
        $this->productRepository->update($productInstance, ['stock' => $newQuantity]);
    }

    private function checkAndNotifyForRestock($product): void {
        $users = User::role('Staff', 'web')->distinct()->get();
        // Log::info('User found total', [$users->count()]);
        // Log::info('Sending notifications to users: ', $users->pluck('id')->toArray());


        if ($this->needsRestock($product)) {
            Notification::send($users, new ProductNeedsRestock($product));
        }
    }

    private function needsRestock($product): bool {
        $newQuantity = $product->stock - $product->pivot->quantity;

        if ($product->min_stock > 0 && $newQuantity <= $product->min_stock) {
            return true;
        }

        $restockThreshold = $product->max_stock * $product->restock_threshold / 100;
        return $newQuantity <= $restockThreshold;
    }
}
