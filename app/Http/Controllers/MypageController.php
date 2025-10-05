<?php

namespace App\Http\Controllers;

// リクエストクラス
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;

// モデルクラス
use App\Models\User;
use App\Models\Order;

// ファサードクラス
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    public function update(UpdateUserRequest $request)
    {   

        try{
            DB::beginTransaction();

            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->postal_code = $request->postal_code;
            $user->prefecture = $request->prefecture;
            $user->address = $request->address;
            $user->save();

            DB::commit();
    
            return redirect()->route('mypage.index')->with('success', 'アカウント情報を更新しました');

        }catch(\Exception $e){

            DB::rollBack();
            Log::error('アカウント情報の更新に失敗しました: ' . $e->getMessage());

            return redirect()->back()->with('error', 'アカウント情報の更新に失敗しました');
        }
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
