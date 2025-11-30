@extends('layouts.app')

@section('title')
{{ $product->name }}
@endsection

@section('css', asset('css/product/show.css'))

@section('content')
<div class="container">
    <p class="mt-2">
        商品 > {{ $product->category->parent->name . ' > ' . $product->category->name }}
    </p>
    <div class="product">
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
        <div class="product_img">
            <img src="{{ asset($product->image) }}" alt="" >
        </div>
        <div class="product_content">
            <div class="product_name">
                {{ $product->name }}
            </div>
            <div class="product_category">
                {{ $product->category->name }}
            </div>
            <div class="product_description">
                {{ $product->description }}
            </div>
            <div class="product_price">
                ¥{{ number_format($product->price )}}
            </div>

            <form method='POST' action="{{ route('line_item.create') }}">
                @csrf
                @if($product->stock <= 0)
                    <p class="product__stock mt-3 text-danger">
                        こちらの商品は現在在庫切れのため購入できません。
                    </p>
                @else
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="product_quantity">
                    <div class="plus"></div>
                    <div class="quantity">1</div>
                    <div class="minus"></div>
                    <input type="hidden" name='quantity' min='1' value='1' require>
                </div>
                <div class="product_cart-btn">
                    <button type='submit' class=''>カートに追加する</button>
                </div>
                @endif
                <div class="favorite">
                    <button type="button" class="favorite-btn" data-item-id="{{ $product->id }}">お気に入りに追加する</button>
                </div>
                <a href="{{ route('product.index') }}" class="back-btn">商品一覧へ戻る</a>
            </form>

        </div>
    </div>
    <div class="review mt-5 text-left">
        <p class="border-bottom p-3">レビュー</p>
        @if($product->reviews->count() == 0)
            <p>この商品のレビューはありません</p>
        @else
        @foreach ($product->reviews as $review)
        <div class="review-item border-bottom">
            <div class="text-warning mb-1">
                {{ str_repeat('★', $review->pivot->rating) }}
                {{ str_repeat('☆', 5 - $review->pivot->rating) }}
            </div>
            <p class="fw-bold mb-1">{{ $review->pivot->title }}</p>
            <p>{{ $review->pivot->comment }}</p>
            @if (Auth::check())
                @if (Auth::user()->id === $review->pivot->user_id)
                    <a href="{{ route('product.review.edit', $review->pivot->product_id) }}" class="btn btn-outline-secondary mb-3">レビューを編集する</a>
                @endif
            @endif
            <div class="d-flex justify-content-between">
                <p class="date-text">{{ $review->pivot->created_at->format('Y/m/d H:i') }}</p>
                <p class="report-text">不適切なレビューを報告する</p>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

<!-- サーバー情報をjsに渡す -->
<script>
    const isAuth = @json(Auth::check());
    const productId = @json($product->id);
    const favoriteExists = @json($product->favorites()->where('user_id', Auth::id() ?? 0)->exists());
    
    const favoriteStoreRoute = @json(route('favorite.store'));
    const favoriteDestroyRoute = @json(route('favorite.destroy'));

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // metaデータからcsrftokenを取得する
</script>

@endsection

@section('js', asset('js/product/show.js'))


