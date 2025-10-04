@extends('layouts.app')

@section('title')
{{ $product->name }}
@endsection

@section('content')
<div class="container">
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
        <img src="{{ asset($product->image) }}" alt="" class="product-img">
        <div class="product__content-header text-center">
            <div class="product__name">
                {{ $product->name }}
            </div>
            <div class="product__price">
                ¥{{ number_format($product->price )}}
            </div>
        </div>
        {{ $product->description }}
        <form method='POST' action="{{ route('line_item.create') }}">
            @csrf
            @if($product->stock <= 0)
                <p class="product__stock mt-3 text-danger">
                    こちらの商品は現在在庫切れのため購入できません。
                </p>
            @else
            <input type="hidden" name="id" value="{{ $product->id }}">
            <div class="product__quantity">
                <input type="number" name='quantity' min='1' value='1' require>
            </div>
            <div class="product__btn-add-cart">
                <button type='submit' class='btn btn-outline-secondary'>カートに追加する</button>
            </div>
            @endif
            <div class="favorite mb-3">
                <button type="button" class="btn btn-outline-danger" data-item-id="{{ $product->id }}">お気に入りに追加する</button>
            </div>
            <a href="{{ route('product.index') }}">商品一覧へ戻る</a>
        </form>
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
                <p style="font-size: 12px; color: #6c757d;">{{ $review->pivot->created_at->format('Y/m/d H:i') }}</p>
                <p style="color: #6c757d;">不適切なレビューを報告する</p>
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


