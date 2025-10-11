@extends('layouts.admin')

@section('title')
    商品編集
@endsection

@section('content')
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.product.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlInput1" class="form-label">商品名</label>
                <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="{{ $product->name }}">
                @if($errors->has('name'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlInput1" class="form-label">商品カテゴリー</label>
                <select class="form-select" name="product_category_id" id="exampleFormControlInput1">
                    @foreach($product_categories as $product_category)
                    <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlTextarea1" class="form-label">価格</label>
                <input type="number" class="form-control" name='price' id="exampleFormControlTextarea1" rows="3" value="{{ $product->price }}"></input>
                @if($errors->has('price'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlTextarea1" class="form-label">在庫数</label>
                <input type="number" class="form-control" name='stock' id="exampleFormControlTextarea1" rows="3" value="{{ $product->stock }}"></input>
                @if($errors->has('stock'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('stock') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlTextarea1" class="form-label">商品説明</label>
                <textarea class="form-control" name='description' id="exampleFormControlTextarea1" rows="3">{{ $product->description }}</textarea>
                @if($errors->has('description'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="formFile" class="form-label">商品画像</label>
                <input class="form-control mb-3" type="file" name='image' id="formFile" value="{{ $product->image }}">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-img" style="width: 100px;">
                @if($errors->has('image'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('image') }}
                    </div>
                @endif
            </div>
            <button type="submit" class="btn btn-success">更新</button>
            <a href="{{ route('admin.product.destroy', $product->id) }}" class="btn btn-danger mx-3">削除</a>
            <a href="{{ route('admin.product.index') }}" class="btn btn-outline-secondary mx-3">戻る</a>
            
        </form>
@endsection