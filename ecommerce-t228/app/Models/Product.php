<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'cost',
        'price',
        'category_id'
    ];

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
}
