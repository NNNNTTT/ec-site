@extends('layouts.admin')

@section('title')
    商品カテゴリー登録
@endsection

@section('content')
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.product_category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlInput1" class="form-label">商品カテゴリー名</label>
                <input type="text" class="form-control" name="name" id="exampleFormControlInput1">
                @if($errors->has('name'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlInput1" class="form-label">スラッグ</label>
                <input type="text" class="form-control" name="slug" id="exampleFormControlInput1">
                @if($errors->has('name'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlInput1" class="form-label">画像</label>
                <input type="file" class="form-control" name="image" id="exampleFormControlInput1">
                @if($errors->has('image'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('image') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlInput1" class="form-label">親カテゴリー</label>
                <select class="form-select" name="parent_id" id="exampleFormControlInput1">
                    <option value="">なし</option>
                    @foreach($product_categories as $product_category)
                    <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">登録</button>
        </form>
@endsection