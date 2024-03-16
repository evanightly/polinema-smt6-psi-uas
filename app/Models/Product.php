<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'price',
        'stock',
        'restock_threshold',
        'min_stock',
        'max_stock',
        'supplier_id'
    ];

    public function transactions() {
        return $this->belongsToMany(Transaction::class)->withPivot('quantity', 'price_per_unit', 'price_subtotal');
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function getImageAttribute() {
        // check if image starts with http
        if (strpos($this->image_path, 'http') === 0) {
            return $this->image_path;
        }
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    public function canBeDeleted() {
        return $this->transactions()->doesntExist();
    }
}
