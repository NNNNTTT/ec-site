<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\LineItem;

class CartController extends Controller
{
    public function index(){
        $cart_id = Session::get('cart');
        $cart = Cart::find($cart_id);

        $total_price = 0;
        foreach($cart->products as $product){
            $total = $product->price * $product->pivot->quantity;
            $total_price += $total;
        }

        return view('cart.index')
            ->with('line_items', $cart->products)
            ->with('total_price', $total_price);
    }

    public function checkout(){
        $cart_id = Session::get('cart');
        $cart = Cart::find($cart_id);

        if(count($cart->products) <= 0){
            return redirect(route('cart.index'));
        }
        $line_items = [];
        foreach ($cart->products as $product) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $product->name,
                        'description' => $product->description ?? '', // null防止
                    ],
                    'unit_amount' => $product->price, // 円単位でOK（※税込なら税込を入れる）
                ],
                'quantity' => $product->pivot->quantity,
            ];
        }
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('cart.success'),
            'cancel_url' => route('cart.index'),
        ]);

        return view('cart.checkout', [
            'session' => $session,
            'publickey' => env('STRIPE_PUBLIC_KEY')
        ]);
    }

    public function success(){
        $cart_id = Session::get('cart');
        LineItem::where('cart_id', $cart_id)->delete();

        return redirect(route('product.index'));
    }
}