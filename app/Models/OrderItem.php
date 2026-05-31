<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // An order item belongs to a specific product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}