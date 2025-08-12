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
use Illuminate\Support\Facades\Session;
use App\Services\StripeService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request){

        if(Auth::check()){
            $user = User::find(Auth::id());
            $total_price = 0;
            foreach($user->products as $product){
                $total = $product->price * $product->pivot->quantity;
                $total_price += $total;
            }
            return view('order.index')
                ->with('total_price', $total_price)
                ->with('line_items', $user->products)
                ->with('user', $user);
        }else{
            return view('order.auth');
        }
    }

    public function login(LoginRequest $request, LineItemService $lineItemService){
        
        //ログイン認証
        $request->authenticate();
        $request->session()->regenerate();

        //ゲストカートをユーザーカートにマージ
        $lineItemService->marge(); 

        //ユーザー情報を取得
        $user = User::find(Auth::id());

        //合計金額を計算
        $total_price = 0;
        foreach($user->products as $product){
            $total = $product->price * $product->pivot->quantity;
            $total_price += $total;
        }

        //注文確定画面を表示
        return view('order.index')
            ->with('total_price', $total_price)
            ->with('line_items', $user->products)
            ->with('user', $user);
    }

    public function register(Request $request, LineItemService $lineItemService){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'regex:/^0\d{1,4}-?\d{1,4}-?\d{3,4}$/'], // 電話番号の正規表現
            'postal_code' => ['required', 'string', 'regex:/^\d{3}-?\d{4}$/'], // 郵便番号
            'prefecture' => ['required', 'string', 'max:255'], // 都道府県
            'address' => ['required', 'string', 'max:255'], // 住所
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'postal_code' => $request->postal_code,
            'prefecture' => $request->prefecture,
            'address' => $request->address,
        ]);

        event(new Registered($user));

        Auth::login($user);

        //ゲストカートをユーザーカートにマージ
        $lineItemService->marge(); 

        //ユーザー情報を取得
        $user = User::find(Auth::id());

        //合計金額を計算
        $total_price = 0;
        foreach($user->products as $product){
            $total = $product->price * $product->pivot->quantity;
            $total_price += $total;
        }

        return view('order.index')
            ->with('total_price', $total_price)
            ->with('line_items', $user->products)
            ->with('user', $user);
    }

    public function store(Request $request){
        DB::beginTransaction();
        try{
            if($request->payment_method === 'credit_card'){
                $stripeService = new StripeService();
                $yoshin_data = $stripeService->yoshin($request);
            }
    
            $order = Order::create([
                'user_id' => $request->user_id,
                'total_price' => $request->total_price,
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
    
            foreach($request->line_items as $line_item){
                $order->products()->attach($line_item['product_id'], [
                    'quantity' => $line_item['quantity'],
                    'price' => $line_item['price'],
                ]);
            }
    
            UserLineItem::where('user_id', $order->user_id)->delete();
    
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

    public function success(){
        return view('order.success');
    }

    public function card(){
        $stripeService = new StripeService();
        $client_secret = $stripeService->createClientSecret();

        return response()->json([
            'client_secret' => $client_secret,
        ]);
    }

    public function card_customer(Request $request){

        $stripeService = new StripeService();
        [$customer_id, $payment_method_id] = $stripeService->createCustomer($request->setup_intent_id);

        return response()->json([
            'customer_id' => $customer_id,
            'payment_method_id' => $payment_method_id,
        ]);
    }
}
