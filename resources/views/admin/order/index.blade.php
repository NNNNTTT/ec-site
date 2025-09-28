@extends('layouts.admin')

@section('title')
    注文一覧
@endsection

@section('content')
<style>
    .status_btn:hover{
        background-color: #000;
        color: #fff !important;
    }
    .active{
        pointer-events: none;         /* クリック無効 */
        cursor: not-allowed; 
        background-color: #000;
        color: #fff !important;               /* 見た目をグレーに（任意） */
    }
</style>
    @php
        if(!isset($status)){
            $status = 'pending';
        }
    @endphp

    <div class="d-flex justify-content-center">
        <a class="status_btn pending" href="{{ route('admin.order.index', ['status' => 'pending']) }}" style="border:1px solid #000; border-bottom: 1px solid #fff; padding: 10px 20px; text-decoration: none; margin-right: 10px; color: #000;">未発送</a>
        <a class="status_btn shipped" href="{{ route('admin.order.index', ['status' => 'shipped']) }}" style="border:1px solid #000; border-bottom: 1px solid #fff; padding: 10px 20px; text-decoration: none; margin-right: 10px; color: #000;">発送済み</a>
        <a class="status_btn canceled" href="{{ route('admin.order.index', ['status' => 'canceled']) }}" style="border:1px solid #000; border-bottom: 1px solid #fff; padding: 10px 20px; text-decoration: none; margin-right: 10px; color: #000;">注文取消し</a>
    </div>
    <form action="{{ route('admin.order.status_update') }}" method="post">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">注文者</th>
                    <th scope="col">注文日</th>
                    <th scope="col">商品名</th>
                    <th scope="col">購入数</th>
                    <th scope="col">ステータス</th>
                    <th scope="col">注文詳細</th>
                </tr>
            </thead>
            @foreach($orders as $order)
            <tbody>
                <tr>
                    <th scope="row">{{ $order->id }}</th>
                    <td style="width: 20%;">{{ $order->user->name }}</td>
                    <td style="width: 10%;">{{ $order->created_at }}</td>
                    <td style="width: 35%;">
                        @foreach($order->products as $product)
                            <p>{{ $product->name }}</p>
                        @endforeach
                    </td>
                    <td style="width: 10%;">
                        @foreach($order->products as $product)
                            <p>{{ $product->pivot->quantity }}</p>
                        @endforeach
                    </td>
                    <td style="width: 10%;">
                        <select name="orders[{{ $order->id }}][status]" id="order_status">
                            <option value="no_change" selected>変更してください</option>
                            <option value="pending">未発送</option>
                            <option value="shipped">発送済み</option>
                            <option value="canceled">注文取消し</option>
                        </select>
                    </td>
                    <td style="width: 10%;"><a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-outline-secondary">注文詳細</a></td>
                </tr>
            </tbody>
            @endforeach
        </table>
        <button class="btn btn-success">ステータス一括更新</button>
    </form>

    <!-- jsファイルに渡すデータ -->
    <div id="status" data-show="{{ $status }}"></div>
    
@endsection

@section('js', asset('js/admin/order/index.js'))