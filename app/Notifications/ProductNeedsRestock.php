<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductNeedsRestock extends Notification {
    use Queueable;

    protected $product;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product) {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'product_image' => $this->product->image,
            'message' => 'Needs restock',
            'supplier_id' => $this->product->supplier->id,
            'isCompleted' => false,
            'url' => route('product.restock-info', $this->product->id),
        ];
    }
}
