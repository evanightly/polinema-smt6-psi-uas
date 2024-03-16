<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'buyer_name',
        'price_total',
        'transaction_date',
    ];

    protected $appends = ['formatted_transaction_date'];

    // This is staff that is responsible for the transaction
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price_per_unit', 'price_subtotal');
    }

    public function getFormattedTransactionDateAttribute() {
        return Carbon::parse($this->transaction_date)->format('l, F j, Y');
    }
}
