@extends('layouts.app')

@section('title')
トップページ
@endsection

@section('css', asset('css/top.css'))

@section('content')
<div class='jumbotron top-img'>
    <p class="text-center text-white top-img-text">{{ config('app.name', 'Laravel') }}</p>
</div>

<div class="container top">
    <div class="center">
        <div class="search">
            <form action="{{ route('product.search') }}" method="POST">
                @csrf
                <input type="text" name="search" placeholder="全ての商品から探す">
                <button type="submit" class=""></button>
            </form>
        </div>

        <a href="/product" class="all-products">All Products ></a>

    </div>

    <section id="category">
        <h2 class="section-title">ITEM CATEGORY</h2>
        <ul class="category-list">
            @foreach($product_categories as $product_category)
            <li>
                <a href="">
                    <img src="{{ asset($product_category->image) }}" alt="{{ $product_category->name }}">
                    <p>{{ $product_category->name }}</p>
                </a>
            </li>
            @endforeach
        </ul>
    </section>

    <section id="ranking">
        <h2 class="section-title">RANKING</h2>
        <div class="col-12">
            <div class='row'>
                @foreach($products as $product)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('product.show', ['parent_slug' => $product->category->parent->slug,'category_slug' => $product->category->slug,'id' => $product->id]) }}">
                        <div class="card card_hover">
                            <img src="{{ asset( $product->image )}}" alt="" class="card-img">
                            <div class="card-body">
                                <p class="card-title">{{ $product->name }}</p>
                                <p class="card-text">{{ $product->category->name }}</p>
                                <p class="card-text">¥{{ number_format($product->price) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class='center'>
            <a href="" class="view_more">view more ></a>
        </div>
    </section>

    <section id="ranking">
        <h2 class="section-title">NEW ARRIVALS</h2>
        <div class="col-12">
            <div class='row'>
                @foreach($products as $product)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('product.show', ['parent_slug' => $product->category->parent->slug,'category_slug' => $product->category->slug,'id' => $product->id]) }}">
                        <div class="card card_hover">
                            <img src="{{ asset( $product->image )}}" alt="" class="card-img">
                            <div class="card-body">
                                <p class="card-title">{{ $product->name }}</p>
                                <p class="card-text">{{ $product->category->name }}</p>
                                <p class="card-text">¥{{ number_format($product->price) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class='center'>
            <a href="" class="view_more">view more ></a>
        </div>
    </section>
</div>


@endsection