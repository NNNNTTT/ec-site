@extends('layouts.app')

@section('title', 'マイページ')

@section('css', asset('css/mypage/index.css'))

@section('content')

<div class='container mt-5'>
    <h2>マイページ</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <ul class='nav nav-tabs'>
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
                <td class="col-6 col-sm-3">ユーザー名</td>
                <td class="col-6 col-sm-9">{{ Auth::user()->name }}</td>
            </tr>
            <tr>    
                <td>メールアドレス</td>
                <td>{{ Auth::user()->email }}</td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>{{ Auth::user()->phone }}</td>
            </tr>
            <tr>
                <td>郵便番号</td>
                <td>{{ Auth::user()->postal_code }}</td>
            </tr>
            <tr>
                <td>ご住所（都道府県）</td>
                <td>{{ Auth::user()->prefecture }}</td>
            </tr>
            <tr>
                <td>ご住所（市区町村-番地）</td>
                <td>{{ Auth::user()->address }}</td>
            </tr>
        </table>
        <div class="mt-5">
            <a href="{{ route('mypage.edit') }}" class="btn btn-outline-secondary">アカウント情報を編集する</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mt-3 btn btn-outline-secondary">ログアウト</button>
            </form>
        </div>
    </div>

    <div id="order-history" class="content">
        <table class="table order-history-table">
            <thead>
                <tr>
                    <th class="col-2">注文番号</th>
                    <th class="col-5">注文日</th>
                    <th class="col-5">注文詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td class="col-2">{{ $order->id }}</td>
                    <td class="col-5">{{ $order->created_at->format('Y-m-d') }}</td>
                    <td class="col-5"><a href="{{ route('mypage.order_detail', $order->id) }}" class="detail-btn">注文詳細</a></td>
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