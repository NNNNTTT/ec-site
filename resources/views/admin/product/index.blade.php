@extends('layouts.admin')

@section('title')
    商品一覧
@endsection

@section('content')
        @if(isset($success))
            <p class="alert alert-success">{{ $success }}</p>
        @endif
        @if(isset($error))
            <p class="alert alert-danger">{{ $error }}</p>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">商品名</th>
                    <th scope="col">価格</th>
                    <th scope="col">商品説明</th>
                    <th scope="col">商品画像</th>
                    <th scope="col">編集</th>
                    <th scope="col">削除</th>
                </tr>
            </thead>
            @foreach($products as $product)
            <tbody>
                <tr>
                    <th scope="row">{{ $product->id }}</th>
                    <td style="width: 20%;">{{ $product->name }}</td>
                    <td style="width: 10%;">{{ $product->price }}</td>
                    <td style="width: 35%;">{{ $product->description }}</td>
                    <td style="width: 10%;"><img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-img" style="width: 100px;"></td>
                    <td style="width: 10%;"><a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-success">編集</a></td>
                    <td style="width: 10%;"><a href="" class="btn btn-danger">削除</a></td>
                </tr>
            </tbody>
            @endforeach
        </table>
@endsection