@extends('layouts.admin')

@section('title')
    商品編集
@endsection

@section('content')
        <form action="{{ route('admin.product.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">商品名</label>
                <input type="text" class="form-control" name="name" id="exampleFormControlInput1" style="max-width: 700px;" value="{{ $product->name }}">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">価格</label>
                <input type="number" class="form-control" name='price' id="exampleFormControlTextarea1" rows="3" style="max-width: 700px;" value="{{ $product->price }}"></input>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">在庫数</label>
                <input type="number" class="form-control" name='stock' id="exampleFormControlTextarea1" rows="3" style="max-width: 700px;" value="{{ $product->stock }}"></input>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">商品説明</label>
                <textarea class="form-control" name='description' id="exampleFormControlTextarea1" rows="3" style="max-width: 700px;">{{ $product->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">商品画像</label>
                <input class="form-control mb-3" type="file" name='image' id="formFile" value="{{ $product->image }}" style="max-width: 700px;">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-img" style="width: 100px;">
            </div>
            <button type="submit" class="btn btn-success">更新</button>
            <a href="{{ route('admin.product.destroy', $product->id) }}" class="btn btn-danger mx-3">削除</a>
            <a href="{{ route('admin.product.index') }}" class="btn btn-outline-secondary mx-3">戻る</a>
            
        </form>
@endsection