<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index(Request $request){
        if($request->query('status')){
            $status = $request->query('status');
            $orders = Order::where('status', $status)->get();
        }else{
            $status = 'pending';
            $orders = Order::where('status', 'pending')->get();
        }
        $show = "order";
        return view('admin.order.index', compact('orders', 'status', 'show'));
    }

    public function show($id){
        $show = "order";
        $order = Order::find($id);
        return view('admin.order.show', compact('order', 'show'));
    }

    public function status_update(Request $request){
        $orders = $request->orders;
        
        foreach($orders as $id => $order){
            if($order['status'] != 'no_change'){
                $old_order = Order::find($id);
                if($old_order->status != $order['status']){
                    $old_order->status = $order['status'];
                    $old_order->save();
                }
            }
        }
        return redirect()->route('admin.order.index');
    }
}