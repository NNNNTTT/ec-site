@extends('layouts.app')

@section('title')
カート
@endsection

@section('content')
<div class="container">
    <div class="cart__title">
        Shopping Cart
    </div>
    @if(count($line_items) > 0)
    <div class="cart-wrapper">
        @foreach ($line_items as $item)
        <div class="card mb-3 card_hover">
            <div class="row">
                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="product-cart-img col-2"/>
                <div class="card-body col-9">
                    <div class="card-product-name col-6">
                        {{ $item->name }}
                    </div>
                    <div class="card-quantity col-2">
                        {{ $item->pivot->quantity }}個
                    </div>
                    <div class="card__total-price col-3 text-center">
                        ￥{{ number_format($item->price * $item->pivot->quantity) }}
                    </div>
                    <form action="{{ route('line_item.delete') }}" method='POST'>
                        @csrf
                        <div class='card__btn-trash col-1'>
                            <input type='hidden' name='id' value='{{ $item->pivot->id}}'>
                                <button type="submit" class="btn btn-sm delete-btn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="cart__sub-total">
        小計：￥{{ number_format($total_price) }}
    </div>
    <button onClick="location.href='{{ route('order.index') }}'" class='cart__purchase btn btn-dark'>
        購入手続きに進む
    </button>
    <a href="{{ route('product.index') }}" class="cart__purchase btn btn-outline-secondary mx-3">お買い物を続ける</a>
    @else
    <div class="cart__empty">
        カートに商品が入っていません。
    </div>
    @endif
</div>
@endsection