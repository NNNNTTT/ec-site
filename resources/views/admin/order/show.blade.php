@extends('layouts.admin')

@section('title')
    注文詳細
@endsection

@section('content')
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>注文番号</td>
                    <td>{{ $order->id }}</td>
                </tr>
                <tr>
                    <td>注文日時</td>
                    <td>{{ $order->created_at }}</td>
                </tr>
                <tr>
                    <td>商品</td>
                    <td>
                        <table class="table table-bordered mt-3" style="width: 70%;">
                            <thead>
                                <tr class="table-light">
                                    <th scope="col" class="col-sm-5" style="font-weight: normal;">商品名</th>
                                    <th scope="col" class="col-sm-2" style="font-weight: normal;">購入数</th>
                                    <th scope="col" class="col-sm-2" style="font-weight: normal;">価格</th>
                                    <th scope="col" class="col-sm-3" style="font-weight: normal;">合計</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->price * $product->pivot->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table table-bordered" style="width: 70%;">
                            <tbody>
                                <tr>
                                    <td class="col-sm-9">送料</td>
                                    <td class="col-sm-3">0</td>
                                </tr>
                                <tr>
                                    <td class="col-sm-9">合計</td>
                                    <td class="col-sm-3">{{ $order->total_price }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>注文者情報</td>
                    <td>
                        <p>お名前：{{ $order->user->name }}</p><br>
                        <p>メールアドレス：{{ $order->user->email }}</p><br>
                        <p>電話番号：{{ $order->user->phone }}</p><br>
                        <p>郵便番号：{{ $order->user->postal_code }}</p><br>
                        <p>ご住所：{{ $order->user->prefecture }}{{ $order->user->address }}</p><br>
                    </td>
                </tr>
                <tr>
                    <td>お届け先情報</td>
                    <td>
                        <p>お名前：{{ $order->shipping_name }}</p><br>
                        <p>郵便番号：{{ $order->shipping_postcode }}</p><br>
                        <p>ご住所：{{ $order->shipping_prefecture }}{{ $order->shipping_address }}</p><br>
                    </td>
                </tr>
                <tr>
                    <td>支払い情報</td>
                    <td>
                        @if($order->payment_method == 'credit_card')
                            <p>クレジットカード</p>
                        @elseif($order->payment_method == 'bank_transfer')
                            <p>銀行振込</p>
                        @elseif($order->payment_method == 'cash_on_delivery')
                            <p>代引き</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>注文ステータス</td>
                    <td>
                        @if($order->status == 'pending')
                            <p>未発送</p>
                        @elseif($order->status == 'shipped')
                            <p>発送済み</p>
                        @elseif($order->status == 'delivered')
                            <p>配達済み</p>
                        @elseif($order->status == 'canceled')
                            <p>注文取消し</p>
                        @endif
                    </td>
                </tr>   

            </table>
            <a href="{{ route('admin.order.index') }}" class="btn btn-dark">戻る</a>
    </div>
@endsection