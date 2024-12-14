<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model // Correct the class name to Order (singular)
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity', 'total_price']; // Make sure to allow mass assignment

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
