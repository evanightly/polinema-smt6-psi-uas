<?php

namespace App\Repositories;

use App\Http\Requests\Notification\MarkAsFinishNotificationRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SupplierResource;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotificationRepository extends Repository {

    public function get($id) {
        $notification = DB::table('notifications')->where('id', $id)->first();

        if ($notification) {
            $notification->data = json_decode($notification->data);
            $notification->product = new ProductResource(Product::find($notification->data->product_id));
            $notification->supplier = new SupplierResource(Supplier::find($notification->data->supplier_id));
        }

        return $notification;
    }

    public function delete(MarkAsFinishNotificationRequest $request) {
        $product_id = $request->product_id;
        $supplier_id = $request->supplier_id;
        $created_at = $request->created_at;

        DB::table('notifications')
            ->whereJsonContains('data->product_id', $product_id)
            ->whereJsonContains('data->supplier_id', $supplier_id)
            ->where('created_at', $created_at)
            ->delete();
    }
}
