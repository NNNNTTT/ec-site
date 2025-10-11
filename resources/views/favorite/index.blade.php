@extends('layouts.app')

@section('title')
お気に入り
@endsection

@section('content')
<div class="container">
    <h2 class="mt-5 mb-3">お気に入り商品</h2>
    <div class="row">
        @foreach ($favoriteProducts as $product)
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <img src="{{ asset($product->image) }}" alt="" class="card-img-top" style='height: 500px;'>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text">¥{{ number_format($product->price) }}</p>
                        <a href="{{ route('product.show', ['parent_slug' => $product->category->parent->slug,'category_slug' => $product->category->slug,'id' => $product->id]) }}" class="btn btn-outline-secondary">詳細</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection