<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sale; // Make sure to import Sale

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
