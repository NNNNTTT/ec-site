<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function carts()
    {
        return $this->belongsToMany(
            Cart::class,
            'line_items',
        )->withPivot(['id', 'quantity']);
    }

    public function users()
    {
        return $this->belongsToMany(
            Cart::class,
            'user_line_items',
        )->withPivot(['id', 'quantity']);
    }
}
