<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'total_price',
        'payment_method',
        'payment_status',
        'shipping_name',
        'shipping_postcode',
        'shipping_prefecture',
        'shipping_address',
        'shipping_phone',
        'stripe_pi_id',
        'stripe_customer_id',
        'stripe_yoshin',
        'stripe_capture',
        'stripe_cancel',
        'shipping_fee'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)
        ->withPivot('quantity', 'price')
        ->withTimestamps();
    }

}
