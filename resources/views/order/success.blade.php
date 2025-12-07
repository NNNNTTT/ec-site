@extends('layouts.app')

@section('title')
    注文完了
@endsection

@section('css', asset('css/order/success.css'))

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <h1 class="text-center mb-4">注文完了</h1>
                <p class="text-center mb-4">注文が完了しました。引き続きお買い物をお楽しみください。</p>
                <div class="text-center">
                    <a href="{{ route('product.index') }}" class="product-btn">商品一覧へ戻る</a>
                </div>
            </div>
        </div>
    </div>
@endsection