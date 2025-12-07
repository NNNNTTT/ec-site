@extends('layouts.admin')

@section('title')
    商品カテゴリー一覧
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
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">商品カテゴリー名</th>
                <th scope="col">スラッグ</th>
                <th scope="col">親カテゴリー</th>
                <th scope="col">編集</th>
                <th scope="col">削除</th>
            </tr>
        </thead>
        @foreach($product_categories as $product_category)
            <tbody>
                <tr>
                    <th scope="row">{{ $product_category->id }}</th>
                    <td>{{ $product_category->name }}</td>
                    <td>{{ $product_category->slug }}</td>
                    @if($product_category->parent)
                        <td>{{ $product_category->parent->name }}</td>
                    @else
                        <td></td>
                    @endif
                    <td><a href="{{ route('admin.product_category.edit', $product_category->id) }}" class="btn btn-success">編集</a></td>
                    <td>
                        <form action="{{ route('admin.product_category.destroy', $product_category->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        @endforeach
    </table>
@endsection