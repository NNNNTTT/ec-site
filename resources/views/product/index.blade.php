@extends('layouts.app')

@section('title')
商品一覧
@endsection

@section('content')
<div class='jumbotron top-img'>
    <p class="text-center text-white top-img-text">{{ config('app.name', 'Laravel') }}</p>
</div>

<div class="container">

    <!-- 商品検索 -->
    <form action="{{ route('product.search') }}" method="POST" class="d-flex justify-content-center gap-2 mb-4 mt-4">
        @csrf
        <input type="text" name="search" placeholder="商品名を検索">
        <button type="submit" class="btn btn-outline-secondary">検索</button>
    </form>
    <div class="container">
        <div class="row align-items-start">
            @include('partials.sidebar')
            <div class='row col-10 ms-2'>
                <div class="top__title">
                    {{ $category_name }}
                </div>
                @foreach($products as $product)
                    <a href="{{ route('product.show', ['parent_slug' => $product->category->parent->slug,'category_slug' => $product->category->slug,'id' => $product->id]) }}" class="col-lg-4 col-md-6">
                        <div class="card card_hover">
                            <img src="{{ asset( $product->image )}}" alt="" class="card-img">
                            <div class="card-body">
                                <p class="card-title">{{ $product->name }}</p>
                                <p class="card-text">{{ $product->category->name }}</p>
                                <p class="card-text">¥{{ number_format($product->price) }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection

