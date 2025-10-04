<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LineItemService;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LineItem;
use App\Models\UserLineItem;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Services\StripeService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\ShippingCalculators\DefaultShippingCalculator;

class OrderController extends Controller
{
    // 注文画面を表示する
    public function index(Request $request){

        if(Auth::check()){

            $user = User::find(Auth::id());
            $subtotal = 0;
            $price_count = 0;

            // 商品の小計を計算する
            foreach($user->products as $product){

                // 在庫がない場合は計算対象から除外
                if($product->stock <= 0) continue;
                
                $price_count++; // 在庫あり商品のカウント（0の場合はビューで在庫切れ表示）
                $subtotal += $product->price * $product->pivot->quantity;     
            }

            // 送料を計算する
            $shippingCalculator = new DefaultShippingCalculator;
            $shipping_fee = $shippingCalculator->calculate($subtotal);

            $total_price = $subtotal + $shipping_fee;

            return view('order.index')
                ->with('total_price', $total_price)
                ->with('line_items', $user->products)
                ->with('user', $user)
                ->with('price_count', $price_count)
                ->with('shipping_fee', $shipping_fee)
                ->with('subtotal', $subtotal);
                
        }else{
            // ログインしていない場合はログイン画面にリダイレクト
            return view('order.auth');
        }
    }

    // 注文処理
    public function store(Request $request){
        DB::beginTransaction();
        try{
            // クレジットカード決済の場合は決済処理を行う
            if($request->payment_method === 'credit_card'){
                $stripeService = new StripeService();
                $yoshin_data = $stripeService->yoshin($request);
            }
    
            $order = Order::create([
                'user_id' => $request->user_id,
                'total_price' => $request->total_price,
                'shipping_fee' => $request->shipping_fee,
                'payment_method' => $request->payment_method,
                'shipping_name' => $request->user_name,
                'shipping_phone' => $request->user_phone,
                'shipping_postcode' => $request->user_postal_code,
                'shipping_prefecture' => $request->user_prefecture,
                'shipping_address' => $request->user_address,
                'stripe_pi_id' => $yoshin_data['stripe_pi_id'] ?? null,
                'stripe_customer_id' => $yoshin_data['stripe_customer_id'] ?? null,
                'stripe_yoshin' => $yoshin_data['stripe_yoshin'] ?? null,
            ]);
            
            // 注文商品を中間テーブルに登録（個数, 価格も保存）
            foreach($request->line_items as $line_item){
                $order->products()->attach($line_item['product_id'], [
                    'quantity' => $line_item['quantity'],
                    'price' => $line_item['price'],
                ]);

                // 在庫を更新
                $product = Product::find($line_item['product_id']);
                $product->stock -= $line_item['quantity'];
                $product->save();
            }
    
            // ユーザーのカートの情報を削除
            UserLineItem::where('user_id', $order->user_id)->delete();
    
            // ゲストのカートの情報を削除
            $cart_id = Session::get('cart');
            if($cart_id){
                LineItem::where('cart_id', $cart_id)->delete();
            }
            
            // 全ての処理が成功したので、データベースへの変更を確定
            DB::commit();
            return redirect()->route('order.success');

        }catch(\Exception $e){
            DB::rollBack();
            Log::error('注文に失敗しました: ' . $e->getMessage());
            return redirect()->back()->with('error', '注文に失敗しました');
        }
    }

    // 注文成功画面を表示
    public function success(){
        return view('order.success');
    }

    // クレジットカード決済のクライアントシークレットを取得
    public function card(){
        $stripeService = new StripeService();
        $client_secret = $stripeService->createClientSecret();

        return response()->json([
            'client_secret' => $client_secret,
        ]);
    }

    // クレジットカード決済の顧客情報を取得
    public function card_customer(Request $request){

        $stripeService = new StripeService();
        // ペイメントメソッドIDと顧客IDを取得
        [$customer_id, $payment_method_id] = $stripeService->createCustomer($request->setup_intent_id);

        return response()->json([
            'customer_id' => $customer_id,
            'payment_method_id' => $payment_method_id,
        ]);
    }
}
