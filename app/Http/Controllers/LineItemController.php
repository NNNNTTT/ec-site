<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LineItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLineItem;
use App\Models\User;

class LineItemController extends Controller
{
    //　カート追加ボタンが押された時の処理
    public function create(Request $request)
    {
        if(Auth::check()){
            $user_id = Auth::user()->id;

            // ログイン中の場合はUserLineItemにカートの情報を保存
            // UserLineItemはusersテーブルとproductsテーブルの中間テーブルです
            $user_line_item = UserLineItem::where('user_id', $user_id)
                ->where('product_id', $request->input('id'))
                ->first();

            // user_line_itemにすでに同じ商品があれば数量をプラスする
            if($user_line_item){
                $user_line_item->quantity += $request->input('quantity');
                $user_line_item->save();
            
            // 商品がなければ新しくカートに追加する
            }else{
                UserLineItem::create([
                    'user_id' => $user_id,
                    'product_id' => $request->input('id'),
                    'quantity' => $request->input('quantity')
                ]);
            }
        }else{

            // ゲストの場合はLineItemにカートの情報を保存
            // LineItemはcartsテーブルとproductsテーブルの中間テーブルです
            $cart_id = Session::get('cart');
            $line_item = LineItem::where('cart_id', $cart_id)
                ->where('product_id', $request->input('id'))
                ->first();
            
            // line_itemにすでに同じ商品があれば数量をプラスする
            if($line_item){
                $line_item->quantity += $request->input('quantity');
                $line_item->save();

            // 商品がなければ新しくカートに追加する
            }else{
                LineItem::create([
                    'cart_id' => $cart_id,
                    'product_id' => $request->input('id'),
                    'quantity' => $request->input('quantity')
                ]);
            }
        }
        return redirect(route('cart.index'));
    }

    public function delete(Request $request){
        if(Auth::check()){
            UserLineItem::destroy($request->input('id'));
            return redirect(route('cart.index'));
        }else{
            LineItem::destroy($request->input('id'));
            return redirect(route('cart.index'));
        }
    }

}
