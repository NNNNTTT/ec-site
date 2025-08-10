<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\LineItem;
use App\Models\UserLineItem;

class LineItemService
{
    public function marge(){
        $user_id = Auth::user()->id;

        $cart_id = Session::get('cart');
        $line_item = LineItem::where('cart_id', $cart_id)->get();

        foreach($line_item as $item){
            $user_line_item = UserLineItem::where('user_id', $user_id)
                ->where('product_id', $item->product_id)
                ->first();
            if($user_line_item){
                $user_line_item->quantity += $item->quantity;
                $user_line_item->save();
            }else{
                UserLineItem::create([
                    'user_id' => $user_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity
                ]);
            }
        }
    }
}