<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishListProducts extends Model
{
    protected $fillable = [
        'product_id',
        'wish_list_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
