@extends('layouts.app')

@section('title', 'マイページ')

@section('content')
<style>
    .nav-item a:hover {
        background-color: #f0f0f0;
        color: inherit;
    }
    .account-table td {
        padding: 20px;
    }
    .content {
        display: none;
    }
    .content.active {
        display: block;
    }
</style>

<div class='container mt-5'>
    <h2>マイページ</h2>
    <ul class='nav nav-tabs mt-5 mb-5'>
        <li class='nav-item'>
            <a href='#account' class='nav-link active'>アカウント情報</a>
        </li>
        <li class='nav-item'>
            <a href='#order-history' class='nav-link'>注文履歴</a>
        </li>
    </ul>

    <div id="account" class="content">
        <table class="table account-table">
            <tr> 
                <td class="col-3">ユーザー名</td>
                <td class="col-9">{{ Auth::user()->name }}</td>
            </tr>
            <tr>    
                <td class="col-3">メールアドレス</td>
                <td class="col-9">{{ Auth::user()->email }}</td>
            </tr>
            <tr>
                <td class="col-3">電話番号</td>
                <td class="col-9">{{ Auth::user()->phone }}</td>
            </tr>
            <tr>
                <td class="col-3">ご住所</td>
                <td class="col-9">{{ Auth::user()->address }}</td>
            </tr>
        </table>
        <a href="{{ route('mypage.edit') }}" class="btn btn-outline-secondary mt-3">アカウント情報を編集する</a>
    </div>

    <div id="order-history" class="content">
        <table class="table order-history-table">
            <thead>
                <tr>
                    <th class="col-1">注文番号</th>
                    <th class="col-3">注文日</th>
                    <th class="col-3">注文商品</th>
                    <th class="col-2">注文金額</th>
                    <th class="col-3">注文詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td class="col-1">{{ $order->id }}</td>
                    <td class="col-3">{{ $order->created_at->format('Y-m-d') }}</td>
                    <td class="col-3">
                        @foreach ($order->products as $product)
                            {{ $product->name }}
                        @endforeach
                    </td>
                    <td class="col-2">{{ $order->total_price }}</td>
                    <td class="col-3"><a href="{{ route('mypage.order_detail', $order->id) }}" class="btn btn-outline-secondary">注文詳細</a></td>
                </tr>
                @endforeach    
            <tbody>
        </table>
    </div>

    <div class="mt-3">
        <a href="{{ route('product.index') }}">トップへ戻る</a>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#account').addClass('active');
        $('.nav-tabs a').click(function() {
            $(this).tab('show');
            if($(this).attr('href') == '#account') {
                $('.account').show();
            } else if($(this).attr('href') == '#order-history') {
                $('.order-history').show();
            }
        });
    });
</script>
@endsection