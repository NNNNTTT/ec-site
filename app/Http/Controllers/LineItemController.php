<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LineItem;
use Illuminate\Support\Facades\Session;

class LineItemController extends Controller
{
    public function create(Request $request)
    {
        $cart_id = Session::get('cart');
        $line_item = LineItem::where('cart_id', $cart_id)
            ->where('product_id', $request->input('id'))
            ->first();

        if($line_item){
            $line_item->quantity += $request->input('quantity');
            $line_item->save();
        }else{
            LineItem::create([
                'cart_id' => $cart_id,
                'product_id' => $request->input('id'),
                'quantity' => $request->input('quantity')
            ]);
        }

        return redirect(route('cart.index'));
    }
}
