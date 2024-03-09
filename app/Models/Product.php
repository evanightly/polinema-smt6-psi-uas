<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'stock',
        'restock_threshold',
        'min_stock',
        'max_stock'
    ];

    public function transactions() {
        return $this->belongsToMany(Transaction::class)->withPivot('quantity');
    }

    public function suppliers() {
        return $this->belongsToMany(Supplier::class);
    }
}
