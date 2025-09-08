@extends('layouts.admin')

@section('title')
    商品登録
@endsection

@section('content')
        <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">商品名</label>
                <input type="text" class="form-control" name="name" id="exampleFormControlInput1" style="max-width: 700px;">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">価格</label>
                <input type="number" class="form-control" name='price' id="exampleFormControlTextarea1" rows="3" style="max-width: 700px;" ></input>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">在庫数</label>
                <input type="number" class="form-control" name='stock' id="exampleFormControlTextarea1" rows="3" style="max-width: 700px;" ></input>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">商品説明</label>
                <textarea class="form-control" name='description' id="exampleFormControlTextarea1" rows="3" style="max-width: 700px;"></textarea>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">商品画像</label>
                <input class="form-control" type="file" name='image' id="formFile"  style="max-width: 700px;">
            </div>
            <button type="submit" class="btn btn-success">登録</button>
        </form>
@endsection