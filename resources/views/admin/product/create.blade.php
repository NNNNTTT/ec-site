@extends('layouts.admin')

@section('title')
    商品登録
@endsection

@section('content')
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlInput1" class="form-label">商品名</label>
                <input type="text" class="form-control" name="name" id="exampleFormControlInput1">
                @if($errors->has('name'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlTextarea1" class="form-label">価格</label>
                <input type="number" class="form-control" name='price' id="exampleFormControlTextarea1" rows="3" ></input>
                @if($errors->has('price'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlTextarea1" class="form-label">在庫数</label>
                <input type="number" class="form-control" name='stock' id="exampleFormControlTextarea1" rows="3" ></input>
                @if($errors->has('stock'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('stock') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlTextarea1" class="form-label">商品説明</label>
                <textarea class="form-control" name='description' id="exampleFormControlTextarea1" rows="3"></textarea>
                @if($errors->has('description'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="formFile" class="form-label">商品画像</label>
                <input class="form-control" type="file" name='image' id="formFile" >
                @if($errors->has('image'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('image') }}
                    </div>
                @endif
            </div>
            <button type="submit" class="btn btn-success">登録</button>
        </form>
@endsection