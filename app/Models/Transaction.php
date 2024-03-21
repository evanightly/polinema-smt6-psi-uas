<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'buyer_name',
        'price_total',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['formatted_transaction_date'];

    // This is staff that is responsible for the transaction

    public function hasConstraints() {
        return $this->user()->withTrashed()->exists() && $this->products()->withTrashed()->exists();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price_per_unit', 'price_subtotal');
    }

    public function getFormattedTransactionDateAttribute() {
        return Carbon::parse($this->created_at)->format('l, F j, Y');
    }
}
