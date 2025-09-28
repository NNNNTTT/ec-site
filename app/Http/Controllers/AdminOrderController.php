<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\StripeService;

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

                    if($old_order->payment_method == 'credit_card'){
                        //決済確定処理
                        if($order['status'] == 'shipped' && $old_order->payment_status == 'unpaid'){
                            $stripeService = new StripeService();
                            $stripeService->capture($old_order);
                            $old_order->stripe_capture = now();
                            $old_order->payment_status = 'paid';
                        }

                        //決済キャンセル処理
                        else if($order['status'] == 'canceled' && $old_order->payment_status == 'unpaid'){
                            $stripeService = new StripeService();
                            $stripeService->cancel($old_order);
                            $old_order->stripe_cancel = now();
                            $old_order->payment_status = 'canceled';
                        }

                    }else{

                        if($order['status'] == 'shipped'){
                            $old_order->payment_status = 'paid';
                        }

                        else if($order['status'] == 'canceled'){
                            $old_order->payment_status = 'canceled';
                        }

                        else if($order['status'] == 'pending'){
                            $old_order->payment_status = 'unpaid';
                        }

                    }

                    $old_order->status = $order['status'];
                    $old_order->save();
                }
            }
        }
        return redirect()->route('admin.order.index');
    }
}