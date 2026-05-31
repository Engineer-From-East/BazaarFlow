<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'phone_number', 
        'shipping_address', // <-- FIXED: Swapped back to shipping_address
        'total_amount', 
        'status'
    ];
}