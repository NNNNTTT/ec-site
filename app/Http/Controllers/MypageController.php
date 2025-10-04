<?php

namespace App\Http\Controllers;

// リクエストクラス
use Illuminate\Http\Request;

// モデルクラス
use App\Models\User;
use App\Models\Order;

// ファサードクラス
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    // マイページを表示する
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('mypage.index', compact('orders'));
    }

    // アカウント情報編集画面を表示する
    public function edit()
    {
        return view('mypage.edit');
    }

    // アカウント情報を更新する
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);
        
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('mypage.index');
    }

    // 注文詳細画面を表示する
    public function order_detail($id)
    {
        $order = Order::find($id);
        if($order->user_id != Auth::user()->id){
            return redirect()->route('mypage.index');
        }

        return view('mypage.order_detail', compact('order'));
    }
}
