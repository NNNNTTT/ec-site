@extends('layouts.app')

@section('title')
商品一覧
@endsection

@section('css', asset('css/product/index.css'))

@section('content')
<div class="container">

    <!-- 商品検索 -->
    <div class="center">
        <div class="search">
            <form action="{{ route('product.search') }}" method="POST">
                @csrf
                <input type="text" name="search" placeholder="全ての商品から探す">
                <button type="submit" class=""></button>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-start justify-content-between">
            <div class="col-12">
                <div class='row'>
                    <h2 class="category_name">
                        {{ $category_name }}
                    </h2>
                    <div class='option'>
                        <div>全20件</div>

                        <select name="filter" id="">
                            <option value="">新着順</option>
                            <option value="">新着順</option>
                            <option value="">新着順</option>
                        </select>

                    </div>

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
                    {{-- ページネーションリンク --}}
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

