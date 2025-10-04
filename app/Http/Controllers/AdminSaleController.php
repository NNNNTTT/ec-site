<?php

namespace App\Http\Controllers;

// リクエストクラス
use Illuminate\Http\Request;

// モデルクラス
use App\Models\Order;

// その他
use DateTime;
use DatePeriod; // 日付の期間を作成する
use DateInterval; // 日付の間隔を作成する

class AdminSaleController extends Controller
{
    // 日毎売上一覧を表示する
    public function days_show(){
        $show = "sale";
        $month = date('Y-m');
        $today = new DateTime();

        $start_date = $today->format('Y-m-01');
        $end = $today->format('t');
        $end_date = $today->format('Y-m-') . $end;

        $start = new DateTime($start_date);
        $end   = new DateTime($end_date);

        $sales = $this->days_getSales($start, $end);

        return view('admin.sale.days', compact('show', 'sales'));
    }

    // 日毎売上一覧を検索する
    public function days_search(Request $request){
        $show = "sale";
        $start_day = $request->start_date;
        $end_day = $request->end_date;

        $start = new DateTime($start_day);
        $end = new DateTime($end_day);

        $sales = $this->days_getSales($start, $end);
        return view('admin.sale.days', compact('show', 'sales'));
    }

    // 期間内の日毎売上一覧を取得する
    protected function days_getSales($start, $end){
        $sales = [];

        // 日毎の期間を作成する
        $period = new DatePeriod(
            $start,
            new DateInterval('P1D'), // 1日ずつ増やす
            $end->modify('+1 day')   // 最終日を含める
        );

        // 日毎の売上配列を作成する
        foreach($period as $date){
            $sales[$date->format('Y-m-d')] = [
                'total_price' => 0,
                'order_count' => 0,
            ];
        }

        $orders = Order::whereBetween('created_at', [$start, $end])->get();
        // 日毎の売上を配列に追加する
        foreach($orders as $order){
            $day = $order->created_at->format('Y-m-d');
            $sales[$day]['total_price'] += $order->total_price;
            $sales[$day]['order_count'] += 1;
        }
        return $sales;
    }

    // 月毎売上一覧を表示する
    public function month_show(){
        $show = "sale";
        $year = date('Y');
        $sales = $this->month_getSales($year);
        return view('admin.sale.month', compact('show', 'sales'));
    }

    // 月毎売上一覧を検索する
    public function month_search(Request $request){
        $show = "sale";
        $year = $request->year;
        $sales = $this->month_getSales($year);
        return view('admin.sale.month', compact('show', 'sales'));
    }

    // 選択した年の月毎売上一覧を取得する
    protected function month_getSales($year){
        $orders = Order::where('created_at', 'like', $year . '%')->get();
        $sales = [];

        for($i = 1; $i <= 12; $i++){
            $month = $year . '-' . sprintf('%02d', $i);
            $sales[$month] = [];
            $sales[$month]['total_price'] = 0;
            $sales[$month]['order_count'] = 0;
        }
        foreach($orders as $order){
            $month = $order->created_at->format('Y-m');
            $sales[$month]['total_price'] += $order->total_price;
            $sales[$month]['order_count'] += 1;
        }
        return $sales;
    }
}
