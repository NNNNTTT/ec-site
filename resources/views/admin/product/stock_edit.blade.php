@extends('layouts.admin')

@section('title')
    在庫編集
@endsection

@section('content')
    @if(isset($success))
        <p class="alert alert-success">{{ $success }}</p>
    @endif
    @if(isset($error))
        <p class="alert alert-danger">{{ $error }}</p>
    @endif
    <form action="{{ route('admin.product.stock_update') }}" method="post">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">チェック</th>
                    <th scope="col">id</th>
                    <th scope="col">商品名</th>
                    <th scope="col">在庫数</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td><input type="checkbox" name="products[]" value="{{ $product->id }}"></td>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        <input type="number" name="stock[{{ $product->id }}]" value="{{ $product->stock }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-success">更新</button>
    </form>
@endsection