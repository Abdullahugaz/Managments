<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
   protected $fillable = [
    'customer_id',
    'product_id',
    'quantity',
    'total_price',   // <-- Use this name
    'price',         // Optional, if you have this column
    'sale_date',     // Optional, if you use this column
];


    // Cast attributes to appropriate types
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'float',
        'total' => 'float',
        'sale_date' => 'datetime',
    ];

    // Relationships

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
