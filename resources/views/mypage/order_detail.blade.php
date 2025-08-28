@extends('layouts.app')

@section('title', '注文詳細')

@section('content')



@if (session('error'))
<div class="container">
    <h2 class="mb-5 mt-5">注文詳細</h2>
    <div class="card">
        <div class="card-body">
            <p>注文番号: {{ $order->id }}</p>
            <p>注文日: {{ $order->created_at->format('Y-m-d') }}</p>
            @foreach ($order->products as $product)
            <div class="d-flex py-3 border-bottom border-top">
                <div class="order_img">
                    <img src="{{ asset($product->image) }}" alt="注文商品画像" width="100">
                </div>
                
                <div class="order_info mx-3">
                    <p class="card-text">{{ $product->name }}</p>
                    <p class="card-text">¥{{ number_format($product->price) }}</p>
                    <p class="card-text">数量: {{ $product->pivot->quantity }}</p>
                    @if ($product->reviews()->where('user_id', Auth::id())->doesntExist())
                        <a href="{{ route('mypage.review.create', $product->id) }}" class='btn btn-outline-secondary'>商品レビューを書く</a>
                    @else
                        <a href="{{ route('mypage.review.edit', $product->id) }}" class='btn btn-outline-secondary'>商品レビューを編集する</a>
                    @endif
                </div>
            </div>        
            @endforeach
            <div class="d-flex flex-column align-items-end mt-3">
                <p>送料:¥{{ number_format( $order->shipping_fee )}}</p>
                <p>合計金額: ¥{{ number_format($order->total_price) }}</p>
            </div>

        </div>
    </div>
</div>
@endsection