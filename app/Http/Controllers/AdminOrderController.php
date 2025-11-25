<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// モデルクラス
use App\Models\Order;

// サービスクラス
use App\Services\StripeService;

// ファサードクラス
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

// 例外クラス
use App\Exceptions\PaymentCaptureException;
use App\Exceptions\PaymentCancelException;


class AdminOrderController extends Controller
{
    // 注文一覧を表示する
    public function index(Request $request){
        if($request->query('status')){
            $status = $request->query('status');
            $orders = Order::where('status', $status)->orderBy('created_at', 'desc')->get();
        }else{
            $status = 'pending';
            $orders = Order::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        }
        $show = "order";
        return view('admin.order.index', compact('orders', 'status', 'show'));
    }

    // 注文詳細を表示する
    public function show($id){
        $show = "order";
        $order = Order::find($id);
        return view('admin.order.show', compact('order', 'show'));
    }

    // 注文ステータス更新処理
    public function status_update(Request $request){
        $orders = $request->orders;
        
        DB::beginTransaction();
        try{
            $stripeService = new StripeService();
            foreach($orders as $id => $order){
                if($order['status'] != 'no_change'){
                    $old_order = Order::find($id);
                    if($old_order->status != $order['status']){
    
                        if($old_order->payment_method == 'credit_card'){
                            //決済確定処理
                            if($order['status'] == 'shipped' && $old_order->payment_status == 'unpaid'){

                                $result = $stripeService->capture($old_order);
                                if(!($result['success'] ?? false)){
                                    throw new PaymentCaptureException($result['error'] ?? '決済(確定)に失敗');
                                }
                                $old_order->stripe_capture = now();
                                $old_order->payment_status = 'paid';
                            }
    
                            //決済キャンセル処理
                            else if($order['status'] == 'canceled' && $old_order->payment_status == 'unpaid'){

                                $result = $stripeService->cancel($old_order);
                                if(!($result['success'] ?? false)){
                                    throw new PaymentCancelException($result['error'] ?? '決済(キャンセル)に失敗');

                                }
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
            DB::commit();
            return redirect()->route('admin.order.index');

        } catch(PaymentCaptureException $e){
            DB::rollBack();
            Log::error('決済確定に失敗: ' . $e->getMessage());
            return redirect()->back()->with('error', '決済(確定)に失敗しました。サーバー管理者にお知らせください。');

        } catch(PaymentCancelException $e){
            DB::rollBack();
            Log::error('決済キャンセルに失敗: ' . $e->getMessage());
            return redirect()->back()->with('error', '決済(キャンセル)に失敗しました。サーバー管理者にお知らせください。');
        }
        
        catch(\Exception $e){
            DB::rollBack();
            Log::error('注文ステータス更新に失敗しました: ' . $e->getMessage());
            return redirect()->back()->with('error', '注文ステータス更新に失敗しました。サーバー管理者にお知らせください。');
        }
    }

    // 領収書を表示する
    public function receipt($order_id)
    {
        $order = Order::find($order_id);

        $pdf = Pdf::loadView('admin.order.receipt', ['order' => $order]);

        return $pdf->stream('receipt_'.$order->id.'.pdf');
    }
}