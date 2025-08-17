<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

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

    public function orders(){
        return $this->belongsToMany(Order::class)
        ->withPivot('quantity', 'price')
        ->withTimestamps();
    }

    public function favorites(){
        return $this->belongsToMany(
            User::class,
            'favorites',
            'product_id',
            'user_id',
        )->withPivot('id');
    }
}
