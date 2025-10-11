@extends('layouts.admin')

@section('title')
    商品カテゴリー編集
@endsection

@section('content')
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.product_category.update', $product_category->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlInput1" class="form-label">商品カテゴリー名</label>
                <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="{{ $product_category->name }}">
                @if($errors->has('name'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlInput1" class="form-label">スラッグ</label>
                <input type="text" class="form-control" name="slug" id="exampleFormControlInput1" value="{{ $product_category->slug }}">
                @if($errors->has('slug'))
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
            </div>
            <div class="mb-3" style="max-width: 700px;">
                <label for="exampleFormControlInput1" class="form-label">親カテゴリー</label>
                <select class="form-select" name="parent_id" id="exampleFormControlInput1">
                    @if($product_category->parent_id)
                    <option value="{{ $product_category->parent_id }}">{{ $product_category->parent_id }}</option>
                    @else
                    <option value="">なし</option>
                    @endif
                    @foreach($product_categories as $product_category)
                    <option value="{{ $product_category->id }}">{{ $product_category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">更新</button>
            <a href="{{ route('admin.product_category.destroy', $product_category->id) }}" class="btn btn-danger mx-3">削除</a>
        </form>
@endsection