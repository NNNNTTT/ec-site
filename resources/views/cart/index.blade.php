@extends('layouts.app')

@section('title')
カート
@endsection

@section('css', asset('css/cart/index.css'))

@section('content')
<div class="container">
    <div class="cart__title">
        ショッピングカート
    </div>
    @if(count($line_items) > 0)
    <p class='cart__description'>ご利用ありがとうございます<br>ショッピングカートには下記の商品が入っています。</p>
    <table class='table'>
        <thead>
            <tr class='top-tr align-middle'>
                <th scope='col' class='w-50'>商品名</th>
                <th scope='col'>価格</th>
                <th scope='col'>数量</th>
                <th scope='col'>小計</th>
                <th scope='col'>削除</th>
            </tr>
        </thead>
        <tbody>
            @foreach($line_items as $item)
            <tr class='align-middle'>
                <td scope='row'>{{ $item->name }}</td>
                <td>¥{{ number_format($item->price) }}</td>
                <td>{{ $item->pivot->quantity }}</td>
                <td>¥{{ number_format($item->price * $item->pivot->quantity) }}</td>
                <td>
                    <form action="{{ route('line_item.delete') }}" method='POST'>
                        @csrf
                        <input type='hidden' name='id' value='{{ $item->pivot->id}}'>
                        <button type='submit' class='btn btn-outline-secondary'>削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class='align-middle'>
                <td colspan="4" class='text-end'>商品合計（税込）</td>
                <td>¥{{ number_format($total_price) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="sp-cart">
        @foreach($line_items as $item)
        <div class="cart-item">
            <div class="cart-item-img">
                <img src="{{ asset($item->image) }}" alt="">
            </div>
            <div class="item-content">
                <div class="cart-item-name">
                    {{ $item->name }}
                </div>
                <div class="cart-item-price">
                    {{ $item->price }}円
                </div>
                <div class="cart-item-quantity">
                    数量：{{ $item->pivot->quantity }}
                </div>
            </div>

            <form class='cart-item-delete' action="{{ route('line_item.delete') }}" method='POST'>
                @csrf
                <input type='hidden' name='id' value='{{ $item->pivot->id}}'>
                <button type='submit' class='btn btn-outline-secondary'>削除</button>
            </form>

        </div>
        @endforeach
        <div class="cart-item-total">
            商品合計（税込）：¥{{ number_format($total_price) }}
        </div>
    </div>

    <div class="cart_btn">
        <div class='back_btn'>
            <a href="{{ route('product.index') }}" class="">お買い物を続ける</a>
        </div>
        <div class='purchase_btn'>
            <a href="{{ route('order.index') }}" class="">購入手続きに進む</a>
        </div>
        
    </div>
    @else
    <div class="cart__empty">
        カートに商品が入っていません。
    </div>
    @endif

</div>
@endsection